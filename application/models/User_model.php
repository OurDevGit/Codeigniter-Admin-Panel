<?php
class User_model extends CI_Model {
 
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_user($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('user');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('user', array('id' => $id));
        return $query->row_array();
    }
    
    public function get_user_login($email, $password)
    {
        $query = $this->db->get_where('user', array('email' => $email, 'password' => md5($password)));        
        //return $query->num_rows();
        return $query->row_array();
    }
    
    public function set_user($id = 0)
    {
        $data = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'phonenumber' => $this->input->post('phonenumber'),
            'address' => $this->input->post('address'),
            'password' => md5($this->input->post('password')),
            'updated_at' => date('Y-m-d H:i:s')
        );
            
        if ($id == 0) {
            return $this->db->insert('user', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('user', $data);
        }
    }
    
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('user');
    }    
    
}
