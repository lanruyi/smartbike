
/********************************
  [Controller Note]
  ./../../models/Entities/Note.php
  ./../../models/note.php
 ********************************/

class Note_controller extends Frontend_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('note'));
        $this->load->model(array('note', 'warning', 'station'));
    }

    public function index() {
        $viewdata['title'] = "Note Center";
        $viewdata['backurlstr'] = $_SERVER['REQUEST_URI'];
        $user = $this->current_user;
        $viewdata['user'] = $user;

        $search = $this->input->get('search');
        if($search){
            $notes = $this->notes_search($search);
            $viewdata['private_notes'] = $notes['private'];
            $viewdata['self_public_notes'] = $notes['self_public'];
            $viewdata['all_public_notes'] = $notes['all_public'];
        }else{
            $stations = $this->station->findBy(array('project' => $this->current_project, 'recycle' => ESC_NORMAL));
            $viewdata['private_notes'] = $this->note->findBy(array('station' => $stations, 'author' => $user, 'openness' => ESC_NOTE_PRIVATE), array('note_time' => 'desc'));
            $viewdata['self_public_notes'] = $this->note->findBy(array('station' => $stations, 'author' => $user, 'openness' => ESC_NOTE_PUBLIC), array('note_time' => 'desc'));
            $viewdata['all_public_notes'] = $this->note->findBy(array('station' => $stations, 'openness' => ESC_NOTE_PUBLIC), array('note_time' => 'desc'));            
        }

        $this->load->view('templates/frontend_header', $viewdata);
        $this->load->view('frontend/note');
        $this->load->view('templates/frontend_footer');
    }

    public function note_edit() {
        $note = $this->note->find($this->input->post('note_id'));
        $edit_result = "修改失败!";
        if ($note) {
            $old_note_time = $note->getNoteTime()->format('Y-m-d H:i:s');
            $note->setContent($this->input->post('note_content'));
            $note->setNoteTime(new DateTime);
            $this->note->save($note);
            $edit_result = $this->feedback_str("edit", $note, $old_note_time);
        }
        $this->session->set_flashdata('flash_succ', $edit_result);
        redirect(urldecode($this->input->post('backurl')), 'location');
    }

    public function note_del() {
        $note = $this->note->find($this->uri->segment(4));
        $delete_result = "删除失败!";
        if ($note) {
            $delete_result = $this->feedback_str("delete", $note);
            $this->doctrine->em->remove($note);
            $this->doctrine->em->flush();
        }
        $this->session->set_flashdata('flash_succ', $delete_result);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }
    
    public function note_openness() {
        $note = $this->note->find($this->uri->segment(4));
        $openness_result = "权限变更失败!";
        if ($note) {
            $old_openness = $note->getOpenness();
            $note->setOpenness($this->uri->segment(5));
            $this->note->save($note);
            $openness_result = $this->feedback_str("openness", $note, $old_openness);
        }
        $this->session->set_flashdata('flash_succ', $openness_result);
        redirect(urldecode($this->input->get('backurl')), 'location');
    }

    private function feedback_str($oper, $note, $old_str) {
        $str = null;
        if ($oper == "edit") {
            $str .= "<span style='font-weight:bold;'>" .
                    $note->getStation()->getNameChn() . " [ " . h_note_openness_name_chn($note) . "笔记  " . $note->getCreateTime()->format('Y-m-d') . " ] 修改成功! </span>
					  记录时间由 " . $old_str . " 变更为 " . $note->getNoteTime()->format('Y-m-d H:i:s');
        }
        if ($oper == "delete") {
            $str .= "<span style='font-weight:bold;'>" .
                    $note->getStation()->getNameChn() . " [ " . h_note_openness_name_chn($note) . "笔记  " . $note->getCreateTime()->format('Y-m-d') . " ] 删除成功! </span>
					  记录时间 " . $note->getNoteTime()->format('Y-m-d H:i:s');
        }
        if ($oper == "openness") {
            $str .= "<span style='font-weight:bold;'>" .
                    $note->getStation()->getNameChn() . " [ " . h_note_openness_name_array($old_str) . "笔记  " . $note->getCreateTime()->format('Y-m-d') . " ] 成功变更为 "
                    . h_note_openness_name_chn($note) . "笔记! </span> 记录时间 " . $note->getNoteTime()->format('Y-m-d H:i:s');
        }
        return $str;
    }
    


}
