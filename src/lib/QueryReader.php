<?php
	/* This class provides to read all the queries from a string and to get every query singly. */

	class QueryReader{

		private $startComment = "/*";
		private $endComment = "*/";
		private $stringQueries; //Queries like a single string
		private $arrayQuery; //Queries like array

		/* Constructor */
		public function __construct($fileContent){
			$this->stringQueries = $this->deleteComments($fileContent);
		}

		/* Read all queries as an array */
		public function asArray(){
			if(isset($stringQueries)){
				throw new Exception("No query in this string.");
			}
			$this->arrayQuery = $this->separateQueries();

			return $this->arrayQuery;
		}

		/* Read all queries as a string */
		public function asString(){
			if(isset($stringQueries)){
				throw new Exception("No query in this string.");
			}
			return $this->stringQuery;
		}

		/* Delete all comments */
		private function deleteComments($fileContent){
			while( ($startPos = strpos($fileContent, $this->startComment )) !== FALSE){
				if(($endPos = strpos($fileContent, $this->endComment, $startPos + strlen($this->startComment))) === FALSE){
					throw new Exception("Comment open and never closed.");
				}
				$fileContent  = $this->strdel($fileContent, $startPos, $endPos + strlen($this->endComment));
			}
			/*
			print_r("<b>FileContent</b><pre>".$fileContent."</pre><br/>");
			*/
			return $fileContent;
		}

		/* Explode the queries in an array */
		private function separateQueries(){
			$arrayQuery = explode(";", $this->stringQueries);
			foreach ($arrayQuery as &$value){
				$value = $value . ";";
			}
			return $arrayQuery;
		}

		/* Delete a piece of a string */
		private function strdel($string, $beginPos, $endPos){
			$length = $endPos - $beginPos;
			$firstPart = substr($string, 0, $beginPos);
			$secondPart = substr($string, $endPos);
			/*
			print_r("<b>InizioPrimaParte</b><pre>".$firstPart."</pre><b>FinePrimaParte</b><br/><br/>");
			print_r("<b>InizioSecondaParte</b><pre>".$secondPart."</pre><b>FineSecondaParte</b><br/><br/>");
			*/
			return $firstPart.$secondPart;
		}
	}