<?
	Class Conexion
	{	

		public function conectarPostgre()
		{
			try{

				$conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                'localhost', 
                5432, 
                'hospital_cumana', 
                'postgres', 
                'admin123');

				$conn = new PDO($conStr);
				if($conn)
				{
					 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					return $conn;
				}
			}
			catch(PDOException $e)
			{
				$e->getMessage();
			}

		}
	}
?>