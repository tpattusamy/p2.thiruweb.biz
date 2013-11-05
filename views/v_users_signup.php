
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
<div class="page_content">
<h2> Sign Up</h2>
<form method='POST' action='/users/p_signup'>

  <span class="text_style"> First Name </span><br>
    <input name='first_name' type='text' required id="first_name">
    <br><br>

<span class="text_style">Last Name</span><br>
    <input name='last_name' type='text' required id="last_name">
    <br><br>

<span class="text_style">Email</span><br>
    <input name='email' type='text' required id="email">
    <br><br>

<span class="text_style">Password</span><br>
    <input name='password' type='password' required id="password">
    <br><br>

    <input type='submit' class="button_signup" onClick="MM_validateForm('first_name','','R','last_name','','R','email','','RisEmail','password','','R');return document.MM_returnValue" value='Submit'>

</form>
</div>