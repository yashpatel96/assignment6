
//------------------------- Validate for Sign up page---------------------------//
function SignUpForm() {

    var result = true;
    var a = document.forms.SignUp.email.value;
    var b = document.forms.SignUp.uname.value;
    
    var c = document.forms.SignUp.bday.value;
    var d = document.forms.SignUp.avtar.value;

    var e = document.forms.SignUp.pswd.value;
    var f = document.forms.SignUp.pswdr.value;


    // javascript regular expression for valid email, username and password requirement


    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,5}$/;

    var uname_v = /^[a-zA-Z0-9_-]+$/;

    var pswd_v = /^\S{8,}$/;

     // initialize email_msg, uname_msg, password_msg and pswdr_msg

     document.getElementById("email_msg").innerHTML = "";
     document.getElementById("uname_msg").innerHTML = "";
     document.getElementById("bday_msg").innerHTML = "";

     document.getElementById("avtar_msg").innerHTML = "";
     document.getElementById("pswd_msg").innerHTML = "";
     document.getElementById("pswdr_msg").innerHTML = "";
    

    // if email is left empty or email format is wrong, error message displays above email field in red color   
    if (a == null || a == "" || email_v.test(a) == false) {

        document.getElementById("email_msg").innerHTML = "Email address empty or wrong format. example: username@somewhere.sth";
        result = false;
    }
    

    // add code here to validate username
    if (b == null || b == "" || uname_v.test(b) == false) {
        document.getElementById("uname_msg").innerHTML = "Please enter the correct format for Username. (No leading or trailing spaces)";
        result = false;
    }


           //-- add code
       //-- validate Birthday --
       if (c == null || c == "") {
        document.getElementById("bday_msg").innerHTML = "Please enter the correct format for Birthday.";
        result = false;
    }

    //-- add code
    //-- validate Profile picture --
    if (d == null || d == "") {
        document.getElementById("avtar_msg").innerHTML = "Please enter the Profile Picture.";
        result = false;
    }
    
    //--validate password--
    //-- add code
    
    if (e == null || e == "" || pswd_v.test(e) == false) {
        document.getElementById("pswd_msg").innerHTML = "Please enter the correct format for Password. (8 characters at least one non-letter) Ex: John@mark";
        result = false;
    }

    // add code here to confirm password
    if (f == null || f == "" || f != e ) {
        document.getElementById("pswdr_msg").innerHTML = "Please enter the correct format for Confirm password. (Which Is Match to Password!)";
        result = false;
    }

    
    // User Information is displayed on the bottom if correct information is entered.		
    if (result == true)
    {
        document.getElementById("display_info").innerHTML = "Email: " + a + "<br>" + "Username: " + b + "<br>" + "Birthday: " + c + "<br>" + "Avtar: " + d + "<br>" + "Password: " + e + "<br>"
            + "Confirm Password: " + f + "<br>";
        document.getElementById("SignUp").reset();
        
    }
}

//------------reset button validate----------------//
function ResetForm()
{
    document.getElementById("display_info").innerHTML="";
    document.getElementById("email").innerHTML = "";
    document.getElementById("uname").innerHTML = "";
    document.getElementById("bday").innerHTML = "";
    document.getElementById("avtar").innerHTML = "";
    document.getElementById("pswd").innerHTML = "";
    document.getElementById("pswdr").innerHTML = "";
    document.getElementById("email_msg").innerHTML = "";
    document.getElementById("uname_msg").innerHTML = "";
    document.getElementById("bday_msg").innerHTML = "";
    document.getElementById("avtar_msg").innerHTML = "";
    document.getElementById("pswd_msg").innerHTML = "";
    document.getElementById("pswdr_msg").innerHTML = "";

} 


//----------------------------Validate for Login Page----------------------------------//

function LoginForm(){

    var result = true;
    var a = document.forms.Login.email.value;
    var b = document.forms.Login.pswd.value;
    
    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var pswd_v = /^\S{8,}$/;

    document.getElementById("email_msg").innerHTML = "";
     document.getElementById("pswd_msg").innerHTML = "";



    //-- validate email --
    
    if (a == null || a == "" || email_v.test(a) == false) {

        document.getElementById("email_msg").innerHTML = "Email address empty or wrong format. example: username@somewhere.sth";
        result = false;
    }
    
    
    
    //-- validate password --
    if (b == null || b == "" || pswd_v.test(b) == false) {
        document.getElementById("pswd_msg").innerHTML = "Please enter the correct format for Password. (8 characters at least one non-letter) Ex: john@mark";
        result = false;
    }

    if (result == true)
    {
        document.getElementById("display_info").innerHTML = "Email: " + a + "<br>" + "Password: " + b + "<br>";
        document.getElementById("Login").reset();
        
    }
}



//-----------------------------Post Recipoe Validation----------------------//

function postForm(e)
{
    e.preventDefault()
    

    var rt = true;
    var str_user_inputs = "";
    var warn = "Check the Following fields: \n";

    //-- validate Recipe Title --

    var x=document.forms.postform.title.value;

    if (x == null || x == "") {
        warn += "Title is empty! \n";
        rt = false;
    }
    else if (x.length > 50) {
        warn += "Maximum length  of username is 50 characters!\n";
        rt = false;
    }

    else { // if everything is okay, then collect username 
        str_user_inputs += "Title: " + x + "\n";
    }


    //-- validate ingredients --
    
    var y=document.forms.postform.ing.value;
    if (y == null || y == "") {
        warn += "Ingredients is empty! \n";
        rt = false;
    }

    else { // if everything is okay, then collect username 
        str_user_inputs += "Ingredients: " + y + "\n";
    }


    //-- validate Recipe Details --
    
    var z=document.forms.postform.details.value;
    if (z == null || z == "") {
        warn += "Details of recipe is empty! \n";
        rt = false;
    }
    
    else { // if everything is okay, then collect username 
        str_user_inputs += "Details: " + z + "\n";
    }
   

    //warning
    if(rt==false)
    {

     alert(warn);
     return false;

    }
    else
    {

    // display the user inputs:
    alert(str_user_inputs);
    document.getElementById("postform").submit();
    return true;
    }
}

    



//----------------------------Dynamic Character Counter for Post Recipe Page----------------------------//
function charcountupdate(str) {
	var lng = str.length;
	document.getElementById("charcount").innerHTML = lng + ' out of 50 characters';
    
    if (lng > 50) {
        document.getElementById("charcount_msg").innerHTML = "Character Limit has been Excceded!!!";
        result = false;
    }
}



//----------------------Voting Button for Increase and Decrese----------//



function counter(e, type, increaseId, decreaseId, numberId) {
    e.preventDefault()
    const increaseButton = document.getElementById(increaseId);
    const decreaseButton = document.getElementById(decreaseId);
    increaseButton.disabled = false
    decreaseButton.disabled = false

    let value = document.getElementById(numberId).value || 0
    if(value < 0 || value >5){
        return
    }
    type === 'ADD' ? value++ : value--
 
    if(value === 5){
        increaseButton.disabled = true
    }
    else if(value ===0){
        decreaseButton.disabled = true
    }
    else{
        increaseButton.disabled = false
        decreaseButton.disabled = false
    }
    document.getElementById(numberId).value = value;
  }
  
//   function decreaseValue(e) {
//       e.preventDefault()
//     const increaseButton = document.getElementById('increase');
//     var value = parseInt(document.getElementById('number').value, 6);

//     // console.log('inc button===', value, increaseButton.disabled)
//     increaseButton.disabled = false
//     if(value === 0){
//         increaseButton.disabled = true
//     }
//     // var value = parseInt(document.getElementById('number').value, 6);
//     value = isNaN(value) ? 0 : value;
//     value < 1 ? value = 1 : '';
//     value--;
//     document.getElementById('number').value = value;

        
//   }

//   const counter = (type) => {
//       let count = 0
//       return type === 'ADD' ? count++ : count--

//   }




