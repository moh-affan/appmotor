<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slugify {

	protected $ci, $latin, $plain;
	protected $primary_key = 'id';

	public function __construct()
	{
		$this->latin = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'ç', 'ü', 'à', 'è', 'ì', 'ò', 'ù', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ç', 'Ü', 'À', 'È', 'Ì', 'Ò', 'Ù');
		$this->plain = array('a', 'e', 'i', 'o', 'u', 'n', 'c', 'u', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'N', 'C', 'U', 'A', 'E', 'I', 'O', 'U');
		$this->ci =& get_instance();
	}

	public function slug($text) {

		$this->ci->load->helper('url');

		$slug = str_replace($this->latin, $this->plain, $text);
		$slug = url_title($slug);
		$slug = strtolower($slug);
		return $slug;

	}

	public function slug_unique($text, $table, $column = 'slug', $id = null) {

		$slug = $this->slug($text);
		if ($this->_check_table($slug, $table, $column) > 0) {
			$i=1;
			$new_slug = $slug.'-'.$i;
			while ($this->_check_table($new_slug, $table, $column) > 0) {
				$i++;
				$new_slug = $slug.'-'.$i;
			}
			return $new_slug;
		} else return $slug;

	}

	protected function _check_table($slug, $table, $column, $id)
	{
		if ($id === NULL)
			$this->ci->db->where($this->primary_key.' !=', $id);

		$this->ci->db->where($column, $slug);
		$this->ci->db->get($table);

		return $this->ci->db->num_rows();
	}

}

/* End of file slugify.php */
/* Location: ./application/libraries/slugify.php */
