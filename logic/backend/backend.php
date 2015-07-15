<?php 
	include_once("general.php");
	
	class backend{
			private function start_connect(){
						$con=mysqli_connect(DB_HOST2,DB_USER2,DB_PASSWORD2,DB_NAME2);
						// Check connection
						if (mysqli_connect_errno())
						  {
						  echo "Failed to connect to MySQL: " . mysqli_connect_error();
						  }
						return $con;				
				}

			private function close_connect($con){
						mysqli_close($con);					
				}
			private function encripter($key){
				return md5($key);
				//return $key;
			}
			public function test(){
					$con = $this->start_connect();
					if($con){
						$this->close_connect($con);
						return true;
					}else{
						return false;
					}
				}
			public function  try_login($user, $pass, $admin = null){
				$con = $this->start_connect();
				$return = array();
				if($admin==null){///user try login
					$query = "SELECT  `id` AS id,  `name` AS name ,  `rol` AS rol 
								FROM  `user` 
								WHERE  `username` =  '".$user."'
								AND  `password` =  '".$this->encripter($pass)."';";					
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$return = array('id'=>$row['id'], 'name'=>$row['name'], 'rol'=>$row['rol']);
						}
					}
				}else{///admin try login like
				
				}
				$this->close_connect($con);
				return $return;
			}
			
			public function get_rating($userid, $objectid){
				$con = $this->start_connect();
				if($con){
					$response = array();
					$average = 0;
					$total = 0;
					$user_rate = false;
					$query = "SELECT FORMAT(AVG(`rate`),2) as 'prom', count(*) as total FROM `user_rate` WHERE `objectid`='".$objectid."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$average = $row["prom"];
							$total = $row["total"];							
						}
						if($total>0){
							$query = "SELECT `rate` as 'rate' FROM `user_rate` WHERE `userid`='".$userid."' AND `objectid`='".$objectid."';";
							$result = mysqli_query($con, $query);
							$user_rate = false;
							if($result){
								while($row = mysqli_fetch_array($con, $query)){
									$user_rate = $row["rate"];									
								}																				
							}
							
						}
					}
					$response= array($average, $total, $user_rate);
					$response= array(2.5, 2400, $user_rate);
										
				}
				$this->close_connect($con);
				return $response;
			}
			
			public function user_object_status($user, $object){
				$con = $this->start_connect();
				$retorno = false;
				
				if($con){
					$query = "SELECT `paymethod`,`timedead` FROM `user_objeto` WHERE `user`='".$user."' AND `object`='".$object."' AND `status`!='0'";	
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = array($row["paymethod"], $row["timedead"]);							
						}						
					}					
				}						
				$this->close_connect($con);
				return $retorno;
			}
			public function add_userobject($user, $object, $paym, $total, $days = null){
				$con = $this->start_connect();
				
				$retorno = false;
				if($con){
					$time = time();
					$time_dead  = 0;
					$paymont = $total;
					if($paym=="1" && $days!=null){
						$time_dead = $time + ($days*24*60*60);
						$paymont = $paym*$days;
					}
					/*$time_dead = ($paym=="1" && $days!=null)? ($time + ($days*24*60*60)) : 0;
					$paymont = $paym=="1" && $days!=null? $paym*$days : $total;*/
					
					$query = "INSERT INTO `user_objeto` 
									(`id`, `user`, `object`, `paymethod`, `paytime`, `timedead`, `paymod`, `paymont`, `status`)
							VALUES (NULL, '".$user."', '".$object."', '".$paym."', '".$time."', '".$time_dead."', '1', '".$paymont."', '1');";	
				
					$result = mysqli_query($con, $query);
					if($result){
						$retorno = true;						
					}
					
				}
				$this->close_connect($con);
				return $retorno;
			}
			public function get_tcval_list($userid){
				$con = $this->start_connect();
				$retorno  =array();
				if($con){
					$time = time();
					$month = date("n",$time);
					$year = date("y",$time);
					$query = "SELECT * FROM user_cards WHERE `user_id`='".$userid."' AND (".$year." < year_expiration OR (".$year." = year_expiration  AND ".$month." < month_expiration)) ORDER BY `primary` DESC;";
					$result = mysqli_query($con, $query);
					if($result){
						$index =0 ;
						while($row = mysqli_fetch_array($result)){
							$retorno[$index][0] = $row["id"];	
							$retorno[$index][1] = $this->mask ( $row["card_number"],0,12);	
							$retorno[$index][2] = $row["card_name"];	
							$index++;
						}
						
					}
				}
				$this->close_connect($con);
				return $retorno;
			}
			public function save_pay($userid, $tc, $object, $description, $total, $type){
				$con = $this->start_connect();
				if($con){
					$time = time();
					$query ="INSERT INTO `user_pay` 
								(`id`, `user_id`, `card`, `element`, `description`, `total`, `type`, `time`) 
								VALUES 
				(NULL, '".$userid."', '".$tc."', '".$object."', '".$description."', '".$total."', '".$type."', '".$time."');";
					$result = mysqli_query($con, $query);
					if($result){
						return true;						
					}
					
				}
				$this->close_connect($con);
				return false;
			}
			private function mask ( $str, $start = 0, $length = null ) {
				$mask = preg_replace ( "/\S/", "*", $str );
				if( is_null ( $length )) {
					$mask = substr ( $mask, $start );
					$str = substr_replace ( $str, $mask, $start );
				}else{
					$mask = substr ( $mask, $start, $length );
					$str = substr_replace ( $str, $mask, $start, $length );
				}
				return $str;
			}						

/********************************USER LOGIC**********************************************/
			public function create_user_new($name, $last, $mail, $pass){
				$new_pass = $this->encripter($pass);
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				
				if($con){
					$query = "SELECT `id` FROM `gua_users` WHERE `username`='".$mail."' AND  `mail`='".$mail."';";					
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["id"];								
						}
					}
					
					

					if($retorno == false ){
						$query = "INSERT INTO `gua_users`(`id`, `name`, `last`, `username`, `mail`, `pass`) VALUES (NULL,'".$name."','".$last."','".$mail."','".$mail."','".$new_pass."');";
						$result = mysqli_query($con, $query);						
						if($result){
							$query = "SELECT `id` FROM `gua_users` WHERE `name`='".$name."' AND `last`='".$last."' AND `username`='".$mail."' AND  `mail`='".$mail."' AND `pass`='".$new_pass."';";
							$result = mysqli_query($con, $query);
							if($result){
								while($row = mysqli_fetch_array($result)){
									$retorno = $row["id"];
																	
								}						
							}					
						}		
					}else{
						$retorno = 0;
						
					}
				}						
				$this->close_connect($con);
				return $retorno;
			}

			public function check_user($mail, $pass){
				$new_pass = $this->encripter($pass);
				$con = $this->start_connect();
				$retorno = false;
				
				if($con){
					$query = "SELECT * FROM `gua_users` WHERE `mail`='".$mail."' AND `username`='".$mail."' AND `pass`='".$new_pass."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["id"];
						}
					}
				}

				if( $retorno == false ){
					$retorno = 0;
				}

				$this->close_connect($con);
				return $retorno;
			}

			public function get_info_user($id){
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				
				if($con){
					$query = "SELECT * FROM `gua_users` WHERE `id`='".$id."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$array[0] = $row["id"];
							$array[1] = $row["name"];
							$array[2] = $row["last"];
							$array[3] = $row["username"];
							$array[4] = $row["mail"];
							$array[5] = $row["pass"];
						}
					}
				}

				$this->close_connect($con);
				return $array;
			}

			public function add_card_user($num, $name, $month, $year, $id){
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				$principal = 1;
				$flag_principal = 0;
				
				if($con){
					$query = "SELECT `card_number` FROM `user_cards` WHERE `card_number`='".$num."' AND `borrada`='0';";					
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["card_number"];								
						}
					}
					
					if($retorno == false ){
						$query = "SELECT `primary` FROM `user_cards` WHERE `user_id`='".$id."' AND `borrada`='0';";					
						$result = mysqli_query($con, $query);
						if($result){
							while($row = mysqli_fetch_array($result)){
								if ( $row["primary"] == 1 ){
									$flag_principal = 1;
								}							
							}
						}
						
						if( $flag_principal == 1 ){
							$principal = 0;
						}
						
						$query = "INSERT INTO `user_cards`(`id`, `card_number`, `card_name`, `month_expiration`, `year_expiration`, `user_id`, `primary`, `borrada`) VALUES (NULL,'".$num."','".$name."','".$month."','".$year."','".$id."','".$principal."','0')";
						$result = mysqli_query($con, $query);						
						if($result){
							$query = "SELECT `id` FROM `user_cards` WHERE `card_number`='".$num."' AND `card_name`='".$name."' AND `month_expiration`='".$month."' AND  `year_expiration`='".$year."' AND `user_id`='".$id."';";
							$result = mysqli_query($con, $query);
							if($result){
								while($row = mysqli_fetch_array($result)){
									$retorno = $row["id"];
								}						
							}					
						}		
					}else{
						$retorno = 0;
					}
				}						
				$this->close_connect($con);
				return $retorno;
			}

			public function get_info_cards_ByUserid($id){
				$con = $this->start_connect();
				$array = array();
				$index = 0;
				$retorno = false;
				
				if($con){
					$query = "SELECT * FROM `user_cards` WHERE `user_id`='".$id."' AND `borrada`<>'1';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$array[$index][0] = $row["id"];
							$array[$index][1] = $row["card_number"];
							$array[$index][2] = $row["card_name"];
							$array[$index][3] = $row["month_expiration"];
							$array[$index][4] = $row["year_expiration"];
							$array[$index][5] = $row["user_id"];
							$array[$index][6] = $row["primary"];
							$array[$index][8] = $row["borrada"];
							$index++;
						}
					}
				}

				$this->close_connect($con);
				return $array;
			}

			public function change_data($id, $name, $last, $mail){
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				
				if($con){
					$query = "SELECT `id` FROM `gua_users` WHERE `username`='".$mail."' AND  `mail`='".$mail."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["id"];								
						}
					}

					if($retorno == false || ( $retorno == $id )){
						$query = "UPDATE `gua_users` SET `name`='".$name."',`last`='".$last."',`username`='".$mail."',`mail`='".$mail."' WHERE `id`='".$id."'";
						$result = mysqli_query($con, $query);
						if($result){
							$query = "SELECT `id` FROM `gua_users` WHERE `name`='".$name."' AND `last`='".$last."' AND `username`='".$mail."' AND  `mail`='".$mail."' AND `pass`='".$new_pass."';";
							$result = mysqli_query($con, $query);
							if($result){
								while($row = mysqli_fetch_array($result)){
									$retorno = $row["id"];							
								}						
							}					
						}		
					}else{
						$retorno = 0;
					}
				}						
				$this->close_connect($con);
				return $retorno;
			}

			public function change_pass($id, $pass){
				$new_pass = $this->encripter($pass);
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				
				if($con){
					$query = "UPDATE `gua_users` SET `pass`='".$new_pass."' WHERE `id`='".$id."'";
					$result = mysqli_query($con, $query);
					if($result){
						$query = "SELECT `id` FROM `gua_users` WHERE `id`='".$id."' AND `pass`='".$new_pass."';";
						$result = mysqli_query($con, $query);
						if($result){
							while($row = mysqli_fetch_array($result)){
								$retorno = $row["id"];							
							}						
						}					
					}else{
						$retorno = 0;
					}
				}						
				$this->close_connect($con);
				return $retorno;
			}

			public function check_old_pass($id, $oldpass){
				$new_pass = $this->encripter($oldpass);
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				
				if($con){
					$query = "SELECT `id` FROM `gua_users` WHERE `id`='".$id."' AND `pass`='".$new_pass."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["id"];							
						}						
					}else{
						$retorno = 0;
					}
				}						
				$this->close_connect($con);
				return $retorno;	
			}

			public function erase_card_user($id){
				$con = $this->start_connect();
				$retorno = 0;
				$arreglo = array();
				$index = 0;
				$user_temp_card = -1;

				if($con){
					$query = "SELECT `primary`,`user_id` FROM `user_cards` WHERE `id`='".$id."';";
					//echo $query;
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$primary = $row["primary"];
							$user_temp_card = $row["user_id"];
						}
					}

					if($primary == 1){
						$query = "SELECT `id` FROM `user_cards` WHERE `user_id`='".$user_temp_card."' AND `id`<>'".$id."' AND `borrada`<>'1' ORDER BY `id` ASC;";
						//echo $query;
						$result = mysqli_query($con, $query);
						if($result){
							while($row = mysqli_fetch_array($result)){
								$arreglo[$index] = $row["id"];
								$index++;
							}

							$query = "UPDATE `user_cards` SET `primary`='1' WHERE `id`='".$arreglo[0]."';";
							//echo $query;
							$result = mysqli_query($con, $query);
						}
					}

					$query = "UPDATE `user_cards` SET `primary`='0', `borrada`='1' WHERE `id`='".$id."';";
					//echo $query;
					$result = mysqli_query($con, $query);
					if($result){
						$retorno = 1;							
					}						
					
				}						
				$this->close_connect($con);
				return $retorno;
			}

			public function get_info_card_ById($id){
				$con = $this->start_connect();
				$array = array();
				
				if($con){
					$query = "SELECT * FROM `user_cards` WHERE `id`='".$id."';";
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$array[0] = $row["id"];
							$array[1] = $row["card_number"];
							$array[2] = $row["card_name"];
							$array[3] = $row["month_expiration"];
							$array[4] = $row["year_expiration"];
							$array[5] = $row["user_id"];
							$array[6] = $row["primary"];
							$array[8] = $row["borrada"];
						}
					}
				}

				$this->close_connect($con);
				return $array;
			}

			public function edit_card_user($num, $name, $month, $year, $id){
				$con = $this->start_connect();
				$array = array();
				$retorno = false;
				$principal = 1;
				$flag_principal = 0;
				
				if($con){
					$query = "SELECT `card_number` FROM `user_cards` WHERE `card_number`='".$num."' AND `borrada`='0';";					
					$result = mysqli_query($con, $query);
					if($result){
						while($row = mysqli_fetch_array($result)){
							$retorno = $row["card_number"];		
							if( $retorno == $num ){
								$retorno = false;
							}
						}
					}
					
					if($retorno == false ){
						$query = "UPDATE`user_cards` SET `card_number`='".$num."', `card_name`='".$name."', `month_expiration`='".$month."', `year_expiration`='".$year."' WHERE `id`='".$id."';";
						$result = mysqli_query($con, $query);						
						if($result){
							$query = "SELECT `id` FROM `user_cards` WHERE `id`='".$id."';";
							//echo $query;
							$result = mysqli_query($con, $query);
							if($result){
								while($row = mysqli_fetch_array($result)){
									$retorno = $row["id"];
								}						
							}					
						}		
					}else{
						$retorno = 0;
					}
				}		

				$this->close_connect($con);
				return $retorno;
			}
/*********************************USER LOGIC**********************************************/

						
	}
?>