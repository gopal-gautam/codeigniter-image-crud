<?php
/**
 * @property PhotoModel $PhotoModel
 * */
class Event extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PhotoModel');

    }

    public function index() {
        $this->load->View('upload');
    }

    public function upload_scanned_doc() {
        $event_id = $this->input->post('event_id');
        $event_subcourse_cat = $this->EventModel->getEventDetail($event_id)[4];
        $field_name = $this->input->post('field_name');
        $existing_photo_guid = $this->input->post('existing_photo_guid');
        $caption = $this->input->post('caption');
        $description = $this->input->post('description');
        if($existing_photo_guid) {
            $this->PhotoModel->replace_photo($existing_photo_guid, $field_name, $event_id, $event_subcourse_cat, $caption, $description);
            $photo_details_array = $this->PhotoModel->get_row(array('guid'=>$existing_photo_guid))[0];
            $photo_details_array['edited'] = TRUE;
        }
        else {
            $photo_id = $this->PhotoModel->do_upload($field_name, $event_id, $event_subcourse_cat, $caption, $description, TRUE);
            $photo_details_array = $this->PhotoModel->get_row(array('id'=>$photo_id))[0];
        }
        header("Content-type:application/json");
        echo json_encode($photo_details_array);
    }

    public function getPhotos_async($event_id) {
        $photos = $this->PhotoModel->get_row(array('event_id'=>$event_id));
        header("Content-type:application/json");
        echo json_encode($photos);
    }

    public function deletePhoto_aysnc($event_id, $field_name, $photo_guid) {
        $ret = $this->PhotoModel->delete_row($where_clause_array=array('event_id'=>$event_id, 'field_name'=>$field_name, 'guid'=>$photo_guid));
        return json_encode($ret);
    }
}