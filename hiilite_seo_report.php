<?php
if(isset($_REQUEST['ga_account_id'])):

$profileId = null;
$accountId = null;

$reports = new WP_Query(
	array(
		'post_type' => 'hii_seo_reports',
		'p'	=> $_REQUEST['ga_account_id']
	)
);
if($reports->have_posts()):
while($reports->have_posts()):
	$reports->the_post();
	
	$accountId = (int)get_post_meta( get_the_ID(), 'hiiseo_ga_account_id', true );


function getService()
{
  // Creates and returns the Analytics service object.

  // Load the Google API PHP Client Library.
  require_once HIILITE_DIR.'/google-api-php-client-master/src/Google/autoload.php';

  // Use the developers console and replace the values with your
  // service account email, and relative location of your key file.
  $service_account_email = '351013696141-n0hvn1u07h3pt2n9nlnkhhg4enovqj0e@developer.gserviceaccount.com';
  $key_file_location = HIILITE_DIR.'/keys/Hiilite GA-295b6f44941a.p12';

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("HelloAnalytics");
  $analytics = new Google_Service_Analytics($client);

  // Read the generated client_secrets.p12 key. 
  $key = file_get_contents($key_file_location);
  $cred = new Google_Auth_AssertionCredentials(
      $service_account_email,
      array(Google_Service_Analytics::ANALYTICS_READONLY), 
      $key
  );
  $client->setAssertionCredentials($cred); 
  if($client->getAuth()->isAccessTokenExpired()) {
    $client->getAuth()->refreshTokenWithAssertion($cred);
  }

  return $analytics;
}

function getFirstprofileId(&$analytics, $accountId) {
  // Get the user's first view (profile) ID.

  // Get the list of accounts for the authorized user.
	 if(isset($accountId)){
  		 $firstAccountId = (int)$accountId;

		// Get the list of properties for the authorized user.
		$properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId); 

		if (count($properties->getItems()) > 0) {
		  $items = $properties->getItems();
		  $firstPropertyId = $items[0]->getId();

		  // Get the list of views (profiles) for the authorized user.
		  $profiles = $analytics->management_profiles
			  ->listManagementProfiles($firstAccountId, $firstPropertyId);

		  if (count($profiles->getItems()) > 0) {
			$items = $profiles->getItems();

			// Return the first view (profile) ID.
			return $items[0]->getId();

		  } else {
			throw new Exception('No views (profiles) found for this user.');
		  }
		} else {
		  throw new Exception('No properties found for this user.');
		}
		 
	} else {
		 $accounts = $analytics->management_accounts->listManagementAccounts();
		 //$items = $accounts->getItems();
		 //$firstAccountId = $items[0]->getId();
		 return $accounts;
	}

}

function getResults(&$analytics, $profileId) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:' . $profileId,
       '7daysAgo',
       'today',
       'ga:sessions');
}

function printResults(&$results) {
  // Parses the response from the Core Reporting API and prints
  // the profile name and total sessions.
  if (count($results->getRows()) > 0) {

    // Get the profile name.
    $profileName = $results->getProfileInfo()->getProfileName();

    // Get the entry for the first entry in the first row.
    $rows = $results->getRows();
    $sessions = $rows[0][0];
	  
	  
  } else {
    print "No results found.\n";
  }
}


$analytics = getService();
$profile = getFirstProfileId($analytics, $accountId);
//$results = getResults($analytics, $profile);
//
//echo '<pre>';
//print_r($profile);
$site_name = $analytics->management_webproperties->listManagementWebproperties($accountId)->items[0]->name;
$site_url = $analytics->management_webproperties->listManagementWebproperties($accountId)->items[0]->websiteUrl;
//echo '</pre>';
?>
<style>
@font-face {
	font-family: Gunar;
	src: url(fonts/The Northern Block - Gunar Light.otf);	
}
@media screen, print {
	#hiilite_seo_report * {
		box-sizing: border-box;
		-webkit-print-color-adjust: exact;
		font-family:Gunar;
	}
	#hiilite_seo_report {
		position: relative;
		background-color: white;
		padding: 10px;
		box-sizing: border-box;
		background-image: url(https://hiilite.com/wp-content/uploads/2015/07/Hiilite-Web-Design-and-Marketing-Kelowna-Water-Harvey-by-Night.jpg?id=1096);
		background-size: 33.3% 100%;
		background-repeat: no-repeat;
		font-size:10pt;

	}
	#hiilite_seo_report img.hiilite_logo {
		position: relative;
		max-width: 35%;
		float: right;
		clear: both;
		max-height:46px;
	}

	#hiilite_seo_report header.main_header {
		clear: both;
		padding: 50px 0 30px 0;
		font-size:18pt;
	}

	#hiilite_seo_report .main_header h1 {
		background-color: #f05023;
		color: white; 
		text-transform: uppercase;
		padding: 10px 0px 10px 20px;
		margin-left: -10px;
		font-size:18pt;
	}

	#hiilite_seo_report .main_header h1 small {
		float: right;
		font-size: 50%;
		background-color: white;
		color: black;
		font-weight: 100;
		margin: -10px;
		padding: 1px 20px;
		text-transform: none;
	}

	#hiilite_seo_report .main_header h2 {
		font-weight: 100;
		background-color: white;
		margin-top: 40px;
		margin-left: -10px;
		padding: 9px 20px;
		position: relative;
		font-size:16pt;
	}

	#hiilite_seo_report .main_header h2 small {
		display: block;
		margin-left: 33.3%;
		font-size: 60%;
		position: absolute;
		top: 38px;
	}

	#hiilite_seo_report article {
		width: 66.6%;
		margin-left: 33.3%;
		padding: 20px 10px 50px 50px;
		page-break-inside:avoid;
	}

	#hiilite_seo_report span.count { 
		background-color: #f05023;
		color: white;
		width: 80px;
		display: inline-block;
		height: 80px;
		text-align: center;
		line-height: 80px;
		border-radius: 50px;
		font-size: 36pt;
		vertical-align: sub;
		margin-right: 25px;
		position: relative;
		font-weight:600;
	}

	#hiilite_seo_report span.count:before {
		content: '';
		display: block;
		position: absolute;
		width: 120px;
		background-color: black;
		height: 1px;
		top: 15px;
		left: 71px;
	}

	#hiilite_seo_report article h1 {
		font-weight: 400;
		margin-bottom: 60px;
		font-size:18pt;

	}

	#hiilite_seo_report article h2 {
		color: #f05023;
		font-size: 18pt;
		text-transform: uppercase;
		font-weight: 100;

	}

	#hiilite_seo_report article table {
		width: 100%;
	}
	#hiilite_seo_report article table tr:nth-child(2n){
		background:rgba(200,200,200,0.1);	
	}
	#hiilite_seo_report #contact_info {
		background-color: white;
		margin: 20px 0 0 -10px;
		width: 34%;
		padding: 5px 20px;
		float:left;
	}
	#hiilite_seo_report h3 {
		background-color: white;
		font-size: 15pt;
		color: #ccc;
		margin: 60px 0 10px -10px;
		float: left;
		clear: both;
		width: 100%;
		padding: 5px 20px;
		font-weight: 400;
		border-top: 1px solid black;
	}

	#hiilite_seo_report #contact_info p {
		font-size: 12pt;
	}

	#hiilite_seo_report #contact_info a {
		color: #f05023;
		text-decoration: none;
	}
	
		
}
	
@media print {
	#wpfooter,#adminmenu, #adminmenumain, #message, #screen-meta, #launcher	{
		display:none;	
	}
	#wpcontent {
		margin-left:0;
		width:100%;
		padding-left:0;
	}
	html {
		background-color:white;	
		-webkit-print-color-adjust: exact;
	}
	html.wp-toolbar {
		padding-top:0;	
	}
}
</style>
<section id="hiilite_seo_report">
	
	<img src="/wp-content/plugins/hiilite-creative-group-branding/images/hiilite-logo-lettermark.png" class="hiilite_logo">
<?php
$startdate = get_post_meta( get_the_ID(), 'hiiseo_ga_startdate', true );
$enddate = date('Y-m-d',strtotime($startdate.' -30 days'));
$prevstartdate = date('Y-m-d',strtotime($startdate.' -31 days'));
$prevenddate = date('Y-m-d',strtotime($startdate.' -61 days'));
//echo date('Y-m-d',$enddate);

?>
	
	<header class="main_header">
		<h1>Hiilite SEO Analytics Report
			<small><?=$site_name?><br>
			<?=$site_url?></small>
		</h1>
		
		<h2><?=$profileId;?>Monthly Report: <?=date('F jS, Y',strtotime($startdate.' -30 days'));?>, to <?=date('F jS, Y',strtotime($startdate));?>
			<small>Compared to: <?=date('F jS, Y',strtotime($startdate.' -61 days'));?>, to <?=date('F jS, Y',strtotime($startdate.' -31 days'));?></small>
		</h2>
		<h3>Contact Information</h3>
		<div id="contact_info">
			<p><a href="http://www.hiilite.com">www.hiilite.com</a></p>
			<p>Please feel free to contact us anytime by email or phone:</p>
			<p>
				<a href="mailto:studio@hiilite.com">Email: studio@hiilite.com</a><br>
				<a href="tel:+18883033444">1.888.303.3444</a>
			</p>
		</div>
		
	</header>
	
	<article class="">
		<h1><span class="count">1</span>Website Traffic</h1>
		<h2>Overall Traffic</h2>
		<table>
			<tr>
				<td>Total visits:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:sessions');
$ga_sessions = $result->rows[0][0];
echo $ga_sessions;
					?></th>
				<td>Total visits last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:sessions');
$ga_prev_sessions = $result->rows[0][0];
echo $ga_prev_sessions;
					?></th>
				
			</tr><tr>
				<td>Unique visitors:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:users');
					
$ga_users = $result->rows[0][0];
echo $ga_users;
					?></th>
				<td>Unique visitors last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:users');
$ga_prev_users = $result->rows[0][0];
echo $ga_prev_users;
					?></th>
				
			</tr>
			<tr>
				<td>Pageviews:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:pageviews');
					
$ga_pageviews = $result->rows[0][0];
echo $ga_pageviews;
					?></th>
				<td>Pageviews last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:pageviews');
$ga_prev_pageviews = $result->rows[0][0];
echo $ga_prev_pageviews;
					?></th>
				
			</tr>
			<tr>
				<td>Bounce rate:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:bounceRate');
$ga_bounceRate = round($result->rows[0][0],2).'%';
echo $ga_bounceRate;
					?></th>
				<td>Bounce rate last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:bounceRate');
$ga_prev_bounceRate = round($result->rows[0][0],2).'%';
echo $ga_prev_bounceRate;
					?></th>
			</tr>
			
			<tr>
				<td>Avg. Visit Duration:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:avgSessionDuration');
					//print_r($result->rows[0][0]);
					$ga_avgSessionDuration = $result->rows[0][0];
					$hours = floor($ga_avgSessionDuration / 3600);
					$mins = floor(($ga_avgSessionDuration - ($hours*3600)) / 60);
					$secs = floor($ga_avgSessionDuration % 60);
echo $hours.':'.$mins.':'.$secs;
					?></th>
				<td>Avg. Visit Duration last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:avgSessionDuration');
					$ga_prev_avgSessionDuration = $result->rows[0][0];
					$hours = floor($ga_prev_avgSessionDuration / 3600);
					$mins = floor(($ga_prev_avgSessionDuration - ($hours*3600)) / 60);
					$secs = floor($ga_prev_avgSessionDuration % 60);
echo $hours.':'.$mins.':'.$secs;
					?></th>
			</tr>
			
			<tr>
				<td>% New Visits:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:percentNewSessions');
					
$ga_percentNewSessions = round($result->rows[0][0],2).'%';
echo $ga_percentNewSessions;
					?></th>
				<td>% New Visits last month:</td>
				<th><?php
					$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:percentNewSessions');
$ga_prev_percentNewSessions = round($result->rows[0][0],2).'%';
echo $ga_prev_percentNewSessions;
					?></th>
			</tr>
			
		</table>
		
		
		
		
		
		<h2>Traffic Summary</h2>
		<table>
			<tr>
				<td>Total visits:</td>
				<th><?php
					echo round((($ga_sessions / $ga_prev_sessions) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			<tr>
				<td>Unique visitors:</td>
				<th><?php
					echo round((($ga_users / $ga_prev_users) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			<tr>
				<td>Pageviews:</td>
				<th><?php
					echo round((($ga_pageviews / $ga_prev_pageviews) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			
			<tr>
				<td>Bounce rate:</td>
				<th><?php
					echo round((($ga_bounceRate / $ga_prev_bounceRate) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			
			<tr>
				<td>Avg. Visit Duration:</td>
				<th><?php
					echo round((($ga_avgSessionDuration / $ga_prev_avgSessionDuration) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			
			<tr>
				<td>% New Visits:</td>
				<th><?php
					echo round((($ga_percentNewSessions / $ga_prev_percentNewSessions) - 1) * 100, 2).'%';
					?>
				</th>
			</tr>
			
		</table>
		
		
		<h2>Channels</h2>
		<table>
		
				<?php
$optParams  = array(
      'dimensions' => 'ga:channelGrouping');
$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $enddate,
						   $startdate,
						   'ga:sessions',
						   $optParams
					);
			
					$ga_sessions_medium = $result->rows;

$result = $analytics->data_ga->get(
						   'ga:' . $profile,
						   $prevenddate,
						   $prevstartdate,
						   'ga:sessions',
						   $optParams
					);
					$ga_prev_sessions_medium = $result->rows;
					//print_r($ga_prev_sessions_medium);
$channelOneStorage = [];
$channelTwoStorage = []; 
for($i = 0; $i < count($ga_sessions_medium); $i++){
	$channelOneStorage[$ga_sessions_medium[$i][0]] = $ga_sessions_medium[$i][1];
}
for($i = 0; $i < count($ga_prev_sessions_medium); $i++){
	$channelTwoStorage[$ga_prev_sessions_medium[$i][0]] = $ga_prev_sessions_medium[$i][1];
}
foreach($channelOneStorage as $key => $value){
	echo '<tr>';
	$label = ($key == '(none)')?'Direct':ucfirst($key);
	echo '<td>'.$label.':</td>';
	
	if($channelTwoStorage[$key] !== null){
		echo '<th>'.round((($value / $channelTwoStorage[$key]) - 1) * 100, 2).'%'.'</th>';
	} else {
		echo '<th>--%</th>';
	}
	
	echo '</tr>'; 
}
					?>
		
			
		</table>
	</article>
	<article class="">
		<h1><span class="count">2</span>Ongoing SEO</h1>
		<h2>SEO Checklist</h2>
		<table>
			<tr>
				<td><?=get_post_meta( get_the_ID(), 'hiiseo_checklist_items', true );?></td>
				<th></th>
			</tr>
			<tr>
				<td>Page Authority</td>
				<th><?=get_post_meta( get_the_ID(), 'hiiseo_page_authority', true );?></th>
			</tr>
			<tr>
				<td>Domain Authority</td>
				<th><?=get_post_meta( get_the_ID(), 'hiiseo_domain_authority', true );?></th>
			</tr>
			<tr>
				<td>URLs Indexed</td>
				<th><?=get_post_meta( get_the_ID(), 'hiiseo_urls_indexed', true );?></th>
			</tr>
		</table>
		
		<h2>Search Results</h2>
		<table>
			<tr>
				<td><strong>At Setup</strong></td>
			</tr>
			<tr>
				<td><?=get_post_meta( get_the_ID(), 'hiiseo_results_at_setup', true );?></td>
			</tr>
			<tr>
				<td><strong>At Report Date</strong></td>
			</tr>
			<tr>
				<td><?=get_post_meta( get_the_ID(), 'hiiseo_results_at_report_date', true );?></td>
			</tr>
		</table>
	</article>
	
	<article class="">
		<h1><span class="count">3</span>Recommendations</h1>
		<?php the_content(); ?>
						
		
	</article>
	
</section>


<?php
// HII
endwhile;
endif;

else:
	?>
	<form method="get">
		<h1>Select Account</h1>
		<pre>
		<?php //print_r($profile); ?>
		</pre>
<?php 
$reports = new WP_Query(
	array(
		'post_type' => 'hii_seo_reports'
	)
);
if($reports->have_posts()):
	while($reports->have_posts()):
		$reports->the_post();

		
		echo '<p><input type="radio" value="'.
				get_the_ID().
				'" name="ga_account_id"> '. 
				get_the_title().'</p>';

	endwhile;
endif;
?>
		<input type="hidden" name="page" value="hiilite-seo-analytics-reports">
		<input type="submit">
	</form>
	
	<?php
endif;
?>