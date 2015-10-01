<?php
/**
 * @author Gustavo Paes (http://gustavopaes.net/)
 * @version 1.107.15 (15/07/2010)
 **/
class JsonDB {

	/**
	 * Caminho completo do arquivo JSON
	 */
	private $file = null;

	/**
	 * Armazena o estado atual do JSON.
	 */
	public $data = null;

	/**
	 * Inicializa lendo o arquivo passado ou iniciando
	 * um json limpo "{}"
	 */
	public function __construct($file = null) {
		if($file) {
			$this->file = $file;
			$this->open($file);
		}
		else {
			$this->data = json_decode("{}");
		}
	}

	/**
	 * Lê o arquivo e processa o JSON
	 */
	public function open() {
		if(file_exists($this->file)) {
			$this->data = json_decode(file_get_contents($this->file));
		}
		return $this;
	}

	/**
	 * Retorna o valor do campo 'field'.
	 * Se o campo não existir, retorna NULL.
	 *
	 * @param String Nome do campo
	 */
	public function read($field) {
		if(property_exists($this->data, $field)){
			return  $this->data->{$field};
			// $tmp = [];
			// foreach ($data as $key => $value) {
			// 	$tmp[]= $value;
			// }

			// return $tmp;
		}
		return null;
	}

	/**
	 * (Re)Define um valor para um campo. Se o campo não existir,
	 * cria.
	 *
	 * @param String Nome do campo
	 * @param String Valor do campo
	 */
	public function set($field, $value) {
		$this->data->{$field} = $value;
		return $this;
	}

	/**
	 * Reescreve/Cria o arquivo JSON com as alterações finais.
	 */
	public function save($file_name = null) {
		if(!$this->file && !$file_name) {
			return false;
		}

		if(!$file_name) {
			$file_name = $this->file;
		}

		// Transforma o Objeto em "String Json"
		$json = json_encode($this->data);

		// Cria o arquivo
		$handle = @fopen($file_name, "w+");
		if($handle) {
			@fwrite($handle, $json);
			@fclose($handle);

			return true;
		}

		return false;
	}
}
?>