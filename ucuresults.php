<?php

//for africastalking
$phonenumber = $_GET['MSISDN'];
$sessionID = $_GET['sessionId'];
$servicecode = $_GET['serviceCode'];
$ussdString = $_GET['text'];

//create data fields
$regNo="";
$fName="";
$lName="";
$gender="";
$genderV="";
$pass="";
$acceptDeny="";

$username="";
$password="";
$year="";
// $semester="";


//N/B: on going live we will change the GET[] method to POST[] (that is how africastalking do their stuff)
$level =0;

if($ussdString != ""){
$ussdString=  str_replace("#", "*", $ussdString);
$ussdString_explode = explode("*", $ussdString);
$level = count($ussdString_explode);
}
if ($level==0){
displaymenu();
}
function displaymenu(){
$ussd_text= "CON Welcome to Barclays Bank. Please reply with \n";
$ussd_text.= "1. Register \n";
$ussd_text.= "2. Login";
ussd_proceed($ussd_text);
}
function ussd_proceed ($ussd_text){
echo $ussd_text;
//exit(0);
}
if ($level>0){
switch ($ussdString_explode[0])
{
case 1:
register($ussdString_explode,$phonenumber);
break;
case 2:
login($ussdString_explode,$phonenumber);
break;
}
}
function register($details,$phone){

if (count($details)==1){
$ussd_text="CON Enter your Account number \n";
ussd_proceed($ussd_text);
}
else if (count($details)==2){
$ussd_text="CON Enter your first name \n";
ussd_proceed($ussd_text);
}
else if(count($details) == 3){
$ussd_text = "CON Enter your last name \n";
ussd_proceed($ussd_text);
}
else if(count($details) == 4){

$ussd_text = "CON Select gender: \n";
$ussd_text.= "1. To select male \n";
$ussd_text.= "2. To select female \n";
ussd_proceed($ussd_text);
}
else if(count($details) == 5){

$ussd_text = "CON set your password \n";
ussd_proceed($ussd_text);
}else if(count($details) == 6){
$ussd_text = "CON 1. Accept registration \n";
$ussd_text.= "2. Cancel";
ussd_proceed($ussd_text);
}else if(count($details) == 7){
$regNo=$details[1];
$fName=$details[2];
$lName=$details[3];
$genderV=$details[4];
$pass=$details[5];
$acceptDeny=$details[6];

if($genderV=="1"){
$gender="Male";
}else if($genderV=="2"){
$gender="Female";
}
if($acceptDeny=="1"){
//=================Do your business logic here===========================
//Remember to put "END" at the start of each echo statement that comes here
echo "END <br> User Details. <br>Account number: " . $regNo . "<br>" .
"Name: " . $fName. " " . $lName . "<br>" .
"Gender: " . $gender . "<br>";
"Password (Encrypted): " . md5($pass) . "<br>";


}else{//Choice is cancel
$ussd_text = "END Your session is over";
ussd_proceed($ussd_text);
}


}
}

function login($details,$phone){
if (count($details)==1){
$ussd_text="CON Enter your account number \n";
ussd_proceed($ussd_text);
}
else if (count($details)==2){
$ussd_text="CON Enter your Pin number \n";
ussd_proceed($ussd_text);
}
else if(count($details) == 3){
$ussd_text = "CON Select your options \n";
$ussd_text.= "1. For Account Balance \n";
$ussd_text.= "2. For Loan Status \n";
$ussd_text.= "3. For Funds Transfer \n";
ussd_proceed($ussd_text);
}
else if(count($details) == 4){
$username=$details[1];
$password=$details[2];
$year=$details[3];
$semester=$details[4];
$accbalance="Ksh. 23,000";
$loanst="Approved/Offer";
echo "END Account Details: <br/>
Account Number: " . $username . "<br/>" .
"Account Balance: " . $accbalance . "<br/>" .
"Loan Status: " . $loanst;
}
}

header('Content-type: text/plain');
echo $ussd_text;
?>
