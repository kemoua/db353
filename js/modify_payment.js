function edit_payments(id)
{
   var quantity=document.getElementById("quantity_val"+id).innerHTML;
   var cost = document.getElementById("cost_val"+id).innerHTML;

   
//create edit fields

  document.getElementById("cost_val"+id).innerHTML='<input type="number" id="cost_text'+id+'" value="'+cost+'">';
  document.getElementById("quantity_val"+id).innerHTML='<input type="number" id="quantity_text'+id+'" value="'+quantity+'">';
   
//display buttons
   document.getElementById("edit_butt_billing"+id).style.display="none";
   document.getElementById("save_butt_billing"+id).style.display="block";
   document.getElementById("cancel_butt_billing"+id).style.display="block";
   document.getElementById("delete_butt_billing"+id).style.display="none";
}

function cancel_edit_payments(id){
  window.location.href = "payments.php?projectid="+id;
}

function save_payments(id)
{
var quantity=document.getElementById("quantity_text"+id).value;
var cost = document.getElementById("cost_text"+id).value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_payments:'edit_payments',
   sub_order_number_val:id,
   cost_val:cost,
   quantity_val:quantity
  },
  success:function(response) {
    // document.getElementById("result").value=response;
   if(response=="success")
   {
    window.location.href = "payments.php?projectid="+project_id;
   }
  }
 });
}

function delete_payments(id)
{
  var project_id=document.getElementById("theprojectid").value;
  if(confirm("Do you really want to delete this Order?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_suborder:'delete_suborder',
   sub_order_number:id
  },
  success:function(response) {
   if(response=="success")
   {
    // var row=document.getElementById("row"+id);
    // row.parentNode.removeChild(row);
    window.location.href = "payments.php?projectid="+project_id;
   }
  }

 });
 }
}

function create_payments()
{
  var project_id=document.getElementById("theprojectid").value;
 var sub_order_number=document.getElementById("new_sub_order_number").value;
 var amount_paid=document.getElementById("new_amount_paid").value;
 var date_of_payment=document.getElementById("new_date_of_payment").value;
 var order_number=document.getElementById("theorder").value;
// alert(project_id);
alert(sub_order_number);
// alert(amount_paid);
// alert(date_of_payment);


 if(confirm("Confirm Payment?")){
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   create_payment:'create_payment',
   sub_order_number_val:sub_order_number,
   amount_paid_val:amount_paid,
   date_of_payment_val:date_of_payment,
   order_number_val:order_number
  },
  success:function(response) {
   if(response=="error1062"){
    // document.getElementById("result").value="ID already exists";
   } else {
    if (response=="error1366"){
      // document.getElementById("result").value="Enter project";
    } else{
        if(response!=""){
          // document.getElementById("result").value=response;
          window.location.href = "suborders.php?projectid="+project_id+"&order="+order_number;
        }
    }
   }
   
  }
 });
}
}
