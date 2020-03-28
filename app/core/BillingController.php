<?
class BillingController {
    function billUsers(){
        $users = User::all();
        
        $this->execute($users);

    }

    function execute ($users) {
                // array of curl handles
$multiCurl = array();

// multi handle
$multipleBills = curl_multi_init();
foreach ($users as $index => $user) {
  // URL from which data will be fetched
  $fetchURL = 'https://demo-bank.com?bill-user='.$user->amount_to_bill;
  $multiCurl[$index] = curl_init();
  curl_setopt($multiCurl[$index], CURLOPT_URL,$fetchURL);
  curl_setopt($multiCurl[$index], CURLOPT_HEADER,0);
  curl_setopt($multiCurl[$index], CURLOPT_RETURNTRANSFER,1);
  curl_multi_add_handle($multipleBills, $multiCurl[$index]);
}
$index=null;
do {
  curl_multi_exec($multipleBills,$index);
} while($index > 0);
// Get Failed Jobs and Redo Function

$failedUsers = [];
foreach($multiCurl as $k => $ch) {
  $result = curl_multi_getcontent($ch);

  if ($result->success == false) {
      array_push($failedUsers, $result->user_id);
  }
  curl_multi_remove_handle($multipleBills, $ch);
}

if (count($failedUsers) > 0) {
    $this->execute($failedUsers);
}
// close
curl_multi_close($multipleBills);
    }
    }