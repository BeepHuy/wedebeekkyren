<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users {	
	public function __construct($config = array())
	{
	
	}
    function index()
    {
        $CI =& get_instance();
        
    }
    function get_user($id=0){
        $th =& get_instance();
        $th->db->where('id',$id);
        
    }
    


}
// END CI_Email class

/* End of file Email.php */
/* Location: ./system/libraries/Email.php */
