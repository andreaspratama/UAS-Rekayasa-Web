<?php
    class Rest{
        var $host = "localhost";
        var $user = "root";
        var $password = "";
        var $database = "kampus";
        var $mahaTable = "maha";
        var $dbConnect = false;

        public function __construct()
        {
            if(!$this->dbConnect) {
                $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
                if($conn->connect_error) {
                    die("Error failed to connect to MySQL: " . $conn->connect_error);
                } else {
                    $this->dbConnect = $conn;
                }
            }
        }

        public function getMaha($mahaId) {
            $sqlQuery = '';
            if($mahaId) {             
            $sqlQuery = "WHERE id_maha = '".$mahaId."'";
            }
            $mahaQuery = " SELECT id_maha, nim, nama, jurusan FROM ". $this->mahaTable." $sqlQuery ORDER BY id_maha ASC";
            $resultData = mysqli_query($this->dbConnect, $mahaQuery);
            $mahaData = array();
            while( $mahaRecord = mysqli_fetch_assoc($resultData) ) {
            $mahaData[] = $mahaRecord;
            }
            header('Content-Type: application/json');
            echo json_encode($mahaData);
        }

        public function insertMaha($mahaData)
        {
            $mahaNim = $mahaData["nim"];
            $mahaNama = $mahaData["nama"];
            $mahaJurusan = $mahaData["jurusan"];

            $mahaQuery = "
            INSERT INTO ".$this->mahaTable."
            SET nim = '".$mahaNim."', nama = '".$mahaNama."', jurusan = '".$mahaJurusan."'";

            mysqli_query($this->dbConnect, $mahaQuery);
            if(mysqli_affected_rows($this->dbConnect) > 0) {
                $message = "maha sukses dibuat.";
                $status = 1;
            } else {
                $message = "maha gagal dibuat.";
                $status = 0;
            }

            $mahaResponse = array(
                'status' => $status,
                'status_message' => $message
            );
            header('Content-Type: application/json');
            echo json_encode($mahaResponse);
        }

        public function updateMaha($mahaData)
        {
            if($mahaData["id"]) {
                $mahaNim = $mahaData["nim"];
                $mahaNama = $mahaData["nama"];
                $mahaJurusan = $mahaData["jurusan"];

                $mahaQuery = "
                    UPDATE ".$this->mahaTable."
                    SET nim = '".$mahaNim."', nama = '".$mahaNama."', jurusan = '".$mahaJurusan."'
                    WHERE id_maha = '".$mahaData["id"]."'";
                
                mysqli_query($this->dbConnect, $mahaQuery);
                if(mysqli_affected_rows($this->dbConnect) > 0) {
                    $message = "maha sukses diperbaiki.";
                    $status = 1;
                } else {
                    $message = "maha gagal diperbaiki.";
                    $status = 0;
                }
            } else {
                $message = "Invalid request.";
                $status = 0;
            }

            $mahaResponse = array(
                'status' => $status,
                'status_message' => $message
            );

            header('Content-Type: application/json');
            echo json_encode($mahaResponse);
        }

        public function deleteMaha($mahaId)
        {
            if($mahaId) {
                $mahaQuery = "
                    DELETE FROM ".$this->mahaTable."
                    WHERE id_maha = '".$mahaId."'
                    ORDER BY id_maha DESC";

                mysqli_query($this->dbConnect, $mahaQuery);
                if(mysqli_affected_rows($this->dbConnect) > 0) {
                    $message = "maha sukses dihapus.";
                    $status = 1;
                } else {
                    $message = "maha gagal dihapus.";
                    $status = 0;
                }
            } else {
                $message = "Invalid request.";
                $status = 0;
            }

            $mahaResponse = array(
                'status' => $status,
                'status_message' => $message
            );

            header('Content-Type: application/json');
            echo json_encode($mahaResponse);
        }
		
		public function getMaha_total_rows($q = NULL) 
		{
			$sqlQuery = '';
			if($q) {
				$sqlQuery = "WHERE id_maha LIKE '%".$q."%' ESCAPE '!'
							OR nim LIKE '%".$q."%' ESCAPE '!'
							OR nama LIKE '%".$q."%' ESCAPE '!'
							OR jurusan LIKE '%".$q."%' ESCAPE '!'";
			}
			$mahaQuery = "
				SELECT id_maha, nim, nama, jurusan
				FROM ".$this->mahaTable." $sqlQuery
				ORDER BY id_maha ASC";
			$resultData = mysqli_query($this->dbConnect, $mahaQuery);
			$mahaResponse = array(
				'total_rows' => mysqli_num_rows($resultData)
			);
			header('Content-Type: application/json');
			echo json_encode($mahaResponse);
		}
		
		public function getMaha_limit($limit, $start = 0, $q = NULL)
		{
			$sqlQuery = '';
			if($q) {
				$sqlQuery = "WHERE id_maha LIKE '%".$q."%' ESCAPE '!'
							OR nim LIKE '%".$q."%' ESCAPE '!'
							OR nama LIKE '%".$q."%' ESCAPE '!'
							OR jurusan LIKE '%".$q."%' ESCAPE '!'";
			}
			$mahaQuery = "
				SELECT id_maha, nim, nama, jurusan
				FROM ".$this->mahaTable." $sqlQuery
				ORDER BY id_maha ASC
				LIMIT ".$start.",".$limit;
				
			$resultData = mysqli_query($this->dbConnect, $mahaQuery);
			$mahaData = array();
			while( $mahaRecord = mysqli_fetch_assoc($resultData) ) {
				$mahaData[] = $mahaRecord;
			}
			header('Content-Type: application/json');
			echo json_encode($mahaData);
		}
    }
?>