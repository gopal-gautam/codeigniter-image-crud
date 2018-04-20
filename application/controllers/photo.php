<?php
/**
 * Description of Photo
 *
 * @author Gopal Gautam
 * @Property PhotoModel $PhotoModel
 */
class Photo extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();       
        $this->load->model('PhotoModel');
        
        //upload photo using the event_id
        $config['upload_path'] = './event_photo_gallery/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']    = '';
        $this->load->library('upload', $config);
    }
    
    function do_upload($field_name, $event_subcourse_cat, $event_id, $caption='', $description='')
    {
        $out_dir = "./event_photo_gallery/$event_subcourse_cat/$event_id";
        if(!file_exists($out_dir)) {
            mkdir($out_dir, '0777', true);
            chmod($out_dir, 0777);
        }
        if ( ! $this->upload->do_upload($field_name))
        {
            $error = array('error' => $this->upload->display_errors());
        }
        else
        {
            $img_data = array('upload_data' => $this->upload->data());
//            $file = $data['upload_data']['full_path'];
            $fileName = $img_data['upload_data']['file_name'];
            $img_extension = pathinfo("./event_photo_gallery/$fileName", PATHINFO_EXTENSION);            
            $newName = sha1_file("./event_photo_gallery/$fileName") . "."  . $img_extension;
            $full_path = "$out_dir/$newName";
            rename("./event_photo_gallery/$fileName", $full_path);
            
            $uploaded_by = $this->session->userdata('username');
            
            $photo_id = $this->savePhotoInfo(array(
                'id'=>NULL,
                'event_id'=>$event_id,
                'path'=>$full_path,
                'filename'=>$newName,
                'original_filename'=>$fileName,
                'field_name'=>$field_name,
                'caption'=>$caption,
                'description'=>$description,
                'size'=>$img_data['file_size'],
                'extension'=>$img_extension,
                'uploaded_by'=>$uploaded_by,
                'data_info'=>$img_data
            ));
            
            return $photo_id;
        }
    }
    
    function savePhotoInfo($data)
    {
        $this->PhotoModel->add_row($data);
    }

    function getSinglePhotoDetails($photo_id)
    {
        return $this->PhotoModel->get_row(array('id'=>$photo_id));
    }
    
    function _remap($param) {
        //Any params submitted to this controller will be directed to index function
        if ( ! method_exists($this, $param))
        {

            $this->index($param);
        }
        else {
            // Since all we get is $method, load up everything else in the URI
            $params = array_slice($this->uri->rsegment_array(), 2);

            // Call the determined method with all params
            call_user_func_array(array($this, $param), $params);
        }
    }
    
    public function index($photo_guid)
    {
        $filename = $this->PhotoModel->get_path($photo_guid);
        if(file_exists($filename)){ 
          header('Content-Length: '.filesize($filename)); //<-- sends filesize header
          header('Content-Type: image/jpg'); //<-- send mime-type header
          header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
          readfile($filename); //<--reads and outputs the file onto the output buffer
          die(); //<--cleanup
          exit; //and exit
        }
    }

    public function get_random_photos() {
        $result = $this->PhotoModel->get_row($where_clause_array='(field_name="representative_photo" OR field_name="other_photo") and (RAND() < 0.1) ');

        header('Content-Type: application/json');
        echo json_encode($result);
    }
    
}
