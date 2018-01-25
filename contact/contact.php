<?php
	$message = array();
	$site = array();
	include __DIR__ . '/config.php'; // $site array should be popluated
	if(array_key_exists('config_library',$site)){
		$site['config_library'] = $site['config_library'] . "/williesMail.php";
	} else {
		echo "<h3><strong>Error: Site settings not found.</strong></h3>";
		return;
	}
	if(file_exists($site['config_library'])){
		require $site['config_library'];
		try{
			$result = setHostDefaults($message); // $message now contains the host settings
			if($result[0] === True){
				// got settings, merge site specific overrides
				$message = array_merge($message, $site);
				//var_dump($message);
			} else {
				// error getting defaults
				echo "<h3><strong>Error getting mail defaults</strong></h3>";
				echo "<ul>";
				reset($result[1]);
				while (list($key, $val) = each($result[1])) {
				    echo "<li>$val</li>";
				}
				echo "</ul>";
				return; // exit on error
			}			
		} catch (Exception $e) {
	    echo "<h3><strong>Exception:</strong> {$e->getMessage()}</h3>";
			return;
		}			
	} else {
	    echo "<h3><strong>Error: williesMail.php file not found at " . $site['config_library'] ."</strong></h3>";
			return;
	}


	if ($_POST){
		// web links in the comment means it's probably spam
		$CommentHasHttp_b = (stripos($_POST['Question'],"http://") > -1);

		if($CommentHasHttp_b === false){
			$request = "Request submitted from the ".gethostname()." web site: " . date("l F j, Y") . "\n\n";
		}
		else {
			$request = "SPAM!!!\n\nLooks like SPAM: " . date("l F j, Y") . "\n\n";
		}
		$request .= "Name: " . $_POST['Name'] . "\n\n";
		$request .= "Phone: " . $_POST['Phone'] . "\n\n";	
		$request .= "Email: " . $_POST['email'] . "\n\n";
		$request .= "Question: " . $_POST['Question'] . "\n";

		$request = stripslashes($request);
        $isNotEmpty = (($_POST['Name']. $_POST['Phone'].$_POST['email'].$_POST['Question']) != "");
		if(($_POST['Additional_Info'] == '') && ($CommentHasHttp_b == false) && ($isNotEmpty)){
			// the secret question is not shown to real users so must be empty
			// No longer actually send the spammers mail
			
			// load values into $message array
			$message['request_email'] = $_POST['email'];
			$message['request_name'] = $_POST['Name'];
			$message['subject'] = "Web Contact";
			$message['body'] = $request;
			$message['responseTimeInSeconds'] = time() - intval($_POST['Code']);
			
			try {
				$result = sendViaSMTP($message);
			} catch (Exception $e){
		    echo "<h3><strong>Exception:</strong> Unable to send message. {$e->getMessage()}</h3>";
				return;
			}
			if($result[0] === True){
				?>
				  <div id="main">
					<h2>Thank You for your interest</h2>
					<p>A reply will be on the way shortly.</p>
					</div>
					<div id="sidebar">&nbsp;</div>
				<?php 
			} else {
				// error sending email
				echo "<h3>Sorry, there is a problem with our email system.</h3>";
				echo "<ul>";
				reset($result[1]);
				while (list($key, $val) = each($result[1])) {
				    echo "<li>$val</li>";
				}
				echo "</ul>";
			}			
			
			/*
			// $site arry now exists
			$fromAddress = $site['from_email'];

			// instantiate the class 
			$mailer = new FreakMailer(); 
			$DEBUG = false;
            $mailer->SMTPDebug = $DEBUG;
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
				$mailer->Subject = "Web Contact for ".gethostname()." - Too fast: " . $interval;
				$mailer->AddAddress('bill@williesworkshop.net', 'Bill Leddy'); 
			}
			// Add an address to send to. 
			elseif($CommentHasHttp_b === false){
			    // default to address is same as sender from config.php
				$mailer->AddAddress($site['from_email'], ''); 
				$mailer->AddBCC('bill@williesworkshop.net', 'Bill Leddy'); 
			}
			else {
				// this looks like spam
				$mailer->AddAddress('bill@williesworkshop.net', 'Bill Leddy'); 
			}
			
			if(!$mailer->Send()) 
			{ ?>
				<h3>Sorry, there is a problem with our email system.</h3>
				<pre><?php echo $mailer->ErrorInfo . " "; ?></pre>
			<?php } 
			else 
			{ ?>
			    <div id="main">
				<h2>Thank You for your interest</h2>
				<p>A reply will be on the way shortly.</p>
				</div>
				<div id="sidebar">&nbsp;</div>
			<?php 
			} 
			$mailer->ClearAddresses(); 
			$mailer->ClearAttachments(); 
			$mailer->ClearCustomHeaders(); 
			$mailer->ClearReplyTos(); 
           */ 
		} // secret question is empty
	} // if Post
	else{
		// show the form:
	?>  <div id="main">
		<h2>Contact Us</h2>
		<div>
            <form action="" method="post" name="form" id="form">
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
                            <input type="submit" name="submit" class="control" value="Send" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        </div>
        <div id="sidebar">&nbsp;</div>
        
	<?php
	} // else show form
	
?>