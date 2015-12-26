<?php
	if ($_POST){
				// web links in the comment means it's probably spam
				$CommentHasHttp_b = (stripos($_POST['Question'],"http://") > -1);

				if($CommentHasHttp_b === false){
					$request = "Request submitted from web site: " . date("l F j, Y") . "\n\n";
				}
				else {
					$request = "SPAM!!!\n\nLooks like Janice Horne SPAM: " . date("l F j, Y") . "\n\n";
				}
				$request .= "Name: " . $_POST['Name'] . "\n\n";
				$request .= "Phone: " . $_POST['Phone'] . "\n\n";	
				$request .= "Email: " . $_POST['email'] . "\n\n";
				$request .= "Question: " . $_POST['Question'] . "\n";

				$request = stripslashes($request);

				if(($_POST['Additional_Info'] == '') && ($CommentHasHttp_b == false)){
					// the secret question is not shown to real users so must be empty
					// No longer actually send the spammers mail
					
					require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
					// $site array now exists
					$fromAddress = $site['from_email'];

					// Grab the FreakMailer class 
					require_once($site['config_library'].'/MailClass.inc'); 
	
					// instantiate the class 
					$mailer = new FreakMailer(); 
	
					// Set the subject 
					$mailer->Subject = "Web Contact"; 
	
					// Body 
					$mailer->Body = $request; 
	
					// Setup the from and Reply to
					$mailer->From = $fromAddress; 
					//$mailer->FromName = $_POST['Name']; 
					$mailer->AddReplyTo($_POST['email'],$_POST['Name']); 
	
					// test that it took a little while for the customer to complete the form
					// If not, we assume it's spam
					$interval = time() - intval($_POST['Code']);
					if ($interval < 5){
						$mailer->Subject = "Web Contact - Too fast: " . $interval;
						$mailer->AddAddress('bill@williesworkshop.net', 'Bill Leddy'); 
					}
					// Add an address to send to. 
					elseif($CommentHasHttp_b === false){
						$mailer->AddAddress('info@bikeandwalk.org', 'Bike and Walk Info'); 
						//$mailer->AddBCC('bill@williesworkshop.net', 'Bill Leddy'); 
					}
					else {
						// this looks like spam
						$mailer->AddAddress('bill@williesworkshop.net', 'Bill Leddy'); 
					}
					
					if(!$mailer->Send()) 
					{ 
						echo "<h3>Sorry, there is a problem with our email system.</h3>";
					} 
					else 
					{ ?>
						<h2>Thank You for your feedback</h2>
						<p>We'll get back to you as soon as we can.</p>
					<?php 
					} 
					$mailer->ClearAddresses(); 
					$mailer->ClearAttachments(); 
					$mailer->ClearCustomHeaders(); 
					$mailer->ClearReplyTos(); 
					
				} // secret question is empty
			} // if Post
			else{
				// show the form:
			?>
				<h2>Contact Us</h2>
				<div>
                    <form action="#" method="post" name="form" id="form">
						<?php
							$timeCode = time();
						?>
						<input type="hidden" name="Code" value="<?php echo $timeCode ?>" >
                        <table>
                            <tr>
                                <th>
                                    Your Name:
                                </th>
                                <td>
                                    <input type="text" name="Name" size="40" />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Your Phone:
                                </th>
                                <td>
                                    <input type="tel" name="Phone" size="40" />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Your email:
                                </th>
                                <td>
                                    <input type="email" name="email" size="40" />
                                </td>
                            </tr>
                            <tr class="addInfo">
                                <th align="left" colspan="2">
                                    Additional Info:
                                </th>
                            </tr>
                            <tr class="addInfo">
                                <td colspan="2">
                                    <textarea name="Additional_Info" rows="8" cols="60"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align:left;padding-left:2em;" colspan="2">
                                    How can I help?:
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="Question" rows="8" cols="60"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <input type="submit" name="submit" class="control" value="Send Email" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                
			<?php
			} // else show form
			?>