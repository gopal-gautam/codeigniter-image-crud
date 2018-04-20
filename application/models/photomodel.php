<?php
/**
 * Description of Photomodel
 *
 * @author Gopal Gautam
 */
class PhotoModel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper('guid');

        $this->safe_model_attrs = array('event_id', 'original_filename', 'field_name', 'caption', 'description', 'guid');
        
        //upload photo using the event_id
        $config['upload_path'] = './event_photo_gallery/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']    = '';
        $this->load->library('upload', $config);


    }

    private function getImageLibConfig($width=1024, $height=1024, $quality='70%')
    {
        $im_config['image_library'] = 'gd2';
        $im_config['create_thumb'] = TRUE;
        $im_config['thumb_marker'] = '';
        $im_config['maintain_ratio'] = TRUE;
        $im_config['width']	= $width;
        $im_config['height']	= $height;
        $im_config['quality']	= $quality;
        return $im_config;
    }

    private function resizeImage($full_path, $full_path_resized)
    {
        $im_config = $this->getImageLibConfig(1024, 1024, '70%');
        $im_config['source_image']	= $full_path;
        $im_config['new_image']	= $full_path_resized;
        $this->load->library('image_lib', $im_config);
        if ( ! $this->image_lib->resize())
        {
            error_log($this->image_lib->display_errors());
        }
    }
    
    public function add_row($data) {
        $success = $this->db->insert('photos', $data);
        $id = $this->db->insert_id();
        if($success == 1)
        {
            return $id;
        }
        return 0;
    }
    

    function replace_photo($existing_photo_guid, $field_name, $event_id, $event_subcourse_cat, $caption='', $description='')
    {
        $out_dir = "./event_photo_gallery/$event_subcourse_cat/$event_id";
        $out_dir_resized = "./event_photo_gallery/$event_subcourse_cat/$event_id/resized";
        if(empty($_FILES[$field_name]['name'])) {

            $photo_update_data = array(
                'caption'=>$caption,
                'description'=>$description,
            );

            $success = $this->update_row($photo_update_data, $where_clause_array=array('event_id'=>$event_id, 'field_name'=>$field_name, 'guid'=>$existing_photo_guid));

            return $success;
        }
        $existing_photo_path = $this->get_path($existing_photo_guid);
        $existing_orig_photo_path = $this->get_orig_photo_path($existing_photo_guid);
        if(!unlink($existing_photo_path)) {
            error_log('Cant delete existing image. Checking if file exists....');
            if(file_exists($existing_photo_path)) {
                error_log('File exist: '.$existing_photo_path);
            }
            else {
                error_log('File doesnot exist: '.$existing_photo_path);
            }
        }
        if(!unlink($existing_orig_photo_path)) {
            error_log('Cant delete existing original image. Checking if file exists....');
            if(file_exists($existing_orig_photo_path)) {
                error_log('File exist: '.$existing_orig_photo_path);
            }
            else {
                error_log('File doesnot exist: '.$existing_orig_photo_path);
            }
        }

        if ( ! $this->upload->do_upload($field_name))
        {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        }
        else
        {
            $img_data = $this->upload->data();
            $fileName = $img_data['file_name'];
            $oldfilepath = "./event_photo_gallery/$fileName";

            $img_extension = pathinfo("./event_photo_gallery/$fileName", PATHINFO_EXTENSION);
            $newName = sha1_file("./event_photo_gallery/$fileName") . "."  . $img_extension;
            $full_path = "$out_dir/$newName";
            $full_path_resized = "$out_dir_resized/$newName";
            rename($oldfilepath, $full_path);

            $this->resizeImage($full_path, $full_path_resized);

            $uploaded_by = $this->session->userdata('username');

            $photo_update_data = array(
                'path'=>$full_path_resized,
                'orig_photo_path'=>$full_path,
                'filename'=>$newName,
                'original_filename'=>$fileName,
                'caption'=>$caption,
                'description'=>$description,
                'size'=>$img_data['file_size'],
                'extension'=>$img_extension,
                'width'=>$img_data['image_width'],
                'height'=>$img_data['image_height'],
                'type'=>$img_data['image_type'],
                'uploaded_by'=>$uploaded_by,
                'data_info'=>JSON_encode($img_data)
            );

            $success = $this->update_row($photo_update_data, $where_clause_array=array('event_id'=>$event_id, 'field_name'=>$field_name, 'guid'=>$existing_photo_guid));

            return $success;
        }
        return 0;
    }

    function do_upload($field_name, $event_id, $event_subcourse_cat, $caption='', $description='', $allow_multi=FALSE)
    {
        $out_dir_parent = "./event_photo_gallery/$event_subcourse_cat";
        $out_dir = "./event_photo_gallery/$event_subcourse_cat/$event_id";
        $out_dir_resized = "./event_photo_gallery/$event_subcourse_cat/$event_id/resized";
        if(!file_exists($out_dir_parent)) {
            mkdir($out_dir_parent, '0777', true);
            chmod($out_dir_parent, 0777);
        }
        if(!file_exists($out_dir)) {
            mkdir($out_dir, '0777', true);
            chmod($out_dir, 0777);
        }
        if(!file_exists($out_dir_resized)) {
            mkdir($out_dir_resized, '0777', true);
            chmod($out_dir_resized, 0777);
        }
        $existing_images = $this->get_row($where_clause_array=array('field_name'=>$field_name, 'event_id'=>$event_id));
        if(!$allow_multi && count($existing_images)>0)
        {
            if(unlink($this->get_path($existing_images[0]['guid']))) {
                $this->delete_row($where_clause_array=array('field_name'=>$field_name, 'event_id'=>$event_id));
            }
        }
        if ( ! $this->upload->do_upload($field_name))
        {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        }
        else
        {
            $img_data = $this->upload->data();
            $fileName = $img_data['file_name'];
            $oldfilepath = "./event_photo_gallery/$fileName";

            $img_extension = pathinfo("./event_photo_gallery/$fileName", PATHINFO_EXTENSION);
            $newName = sha1_file("./event_photo_gallery/$fileName") . "."  . $img_extension;
            $full_path = "$out_dir/$newName";
            $full_path_resized = "$out_dir_resized/$newName";
            rename($oldfilepath, $full_path);

            $this->resizeImage($full_path, $full_path_resized);

            $uploaded_by = $this->session->userdata('username');
            
            $photo_insert_data = array(
                'id'=>NULL,
                'event_id'=>$event_id,
                'path'=>$full_path_resized,
                'orig_photo_path'=>$full_path,
                'filename'=>$newName,
                'original_filename'=>$fileName,
                'field_name'=>$field_name,
                'caption'=>$caption,
                'description'=>$description,
                'size'=>$img_data['file_size'],
                'extension'=>$img_extension,
                'width'=>$img_data['image_width'],
                'height'=>$img_data['image_height'],
                'type'=>$img_data['image_type'],
                'uploaded_by'=>$uploaded_by,
                'data_info'=>JSON_encode($img_data),
                'guid'=> getGUID()
            );
            
            $photo_id = $this->add_row($photo_insert_data);
            
            return $photo_id;
        }
    }
    
    function get_row($where_clause_array)
    {
        $this->db->select($this->safe_model_attrs);
        return $this->db->get_where('photos', $where_clause_array)->result_array();
    }

    function get_path($guid)
    {
        $photo = $this->db->get_where('photos', array('guid'=>$guid))->result()[0];
        return ($photo->path != '')?$photo->path:$photo->orig_photo_path;
    }

    function get_orig_photo_path($guid)
    {
        $photo = $this->db->get_where('photos', array('guid'=>$guid))->result()[0];
        return $photo->orig_photo_path;
    }

    function delete_photo($guid)
    {
        $image_path = $this->get_path($guid);
        $orig_image_path = $this->get_orig_photo_path($guid);
        return unlink($image_path) && unlink($orig_image_path);
    }
    
    function delete_row($where_clause_array)
    {
        if (!key_exists('guid', $where_clause_array)) {
            return;
        }
        $this->delete_photo($where_clause_array['guid']);
        $this->db->delete('photos', $where_clause_array);
    }

    function update_row($photo_update_data, $where_clause_array)
    {
        $this->db->set($photo_update_data);
        $this->db->where($where_clause_array);
        return $this->db->update('photos');
    }
}
