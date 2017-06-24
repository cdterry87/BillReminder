$(function(){
   /* --------------------------------------------------------------------------------
    * Global Variables.
    * -------------------------------------------------------------------------------- */
   numeric_error     = 'Value must be numeric!';
   day_error	     = 'Invalid Day!';
   form              = $('form');
   messages          = $('#messages');
   
   /* --------------------------------------------------------------------------------
    * On-load Functions.
    * -------------------------------------------------------------------------------- */
   populate_screen();
   get_messages();
   
   /* --------------------------------------------------------------------------------
    * Populate screen with data from JSON.
    * -------------------------------------------------------------------------------- */
   function populate_screen(){
      console.log('populate_screen()');
      
      //Setup a request to retrieve data to populate on the screen.
      $.ajax({
         async:		    false,
         method:		"POST",
         type:		    "HTML",
         url:           base_url+'AJAX/Populate'
      })
      .done(function(data){
         //If a JSON object is retrieved from the request, try to parse the data onto the screen.
         try{
            obj=jQuery.parseJSON(data);
            $.each(obj, function(name, value){
               if(form.find('[name="'+name+'"]').attr('type')!='submit'){
                  //Is this is a radio button?
                  if(form.find('[name="'+name+'"]').attr('type')=='radio'){
                     //This is a radio button.
                     form.find('[id="'+name+'_'+value+'"]').prop('checked', 'checked');
                  }else{
                     //This is NOT a radio button. Is this a checkbox?
                     if(form.find('[name="'+name+'"][type=checkbox]').attr('type')=='checkbox'){
                        if(value=="CHECKED"){
                           //This is a CHECKED checkbox.
                           form.find('[name="'+name+'"]').prop('checked', true);
                        }else{
                           //This is an UNCHECKED checkbox.
                           form.find('[name="'+name+'"]').prop('checked', false);
                        }
                     }else{
                        //This is a standard input field.
                        form.find('[name="'+name+'"]').val(value);
                     }
                  }
               }
            });
            
            console.log('Screen populated successfully!');
         }catch(e){
             
         }
      })
	  .fail(function(xhr, status, error){
		 console.log('Populate screen failed!');
	  });
   }
   
   /* --------------------------------------------------------------------------------
    * Get messages.
    * -------------------------------------------------------------------------------- */
   function get_messages(){
      console.log('get_messages()');
      
      //Clear existing messages.
      clear_messages();
      
      //Setup a request to retrieve messages.
      $.ajax({
         method:	 "POST",
         type:       "HTML",
         url:	     base_url+'AJAX/Messages'
      })
      .done(function(data){
		 console.log('Messages retrieved successfully!');
         //If messages are present.
         if(data!=''){
            //Display messages.
            messages.html(data);
            
            //Format currency.
            $('.currency').formatCurrency();
         }
      })
      .fail(function(xhr, status, error){
         console.log('Message Retrieval Error: '+xhr.responseText);
      });
   }
    
   /* --------------------------------------------------------------------------------
    * Clear existing messages.
    * -------------------------------------------------------------------------------- */
   function clear_messages(){
      console.log('clear_messages()');
       
      messages.html('');
   }
   
   /* --------------------------------------------------------------------------------
    * Form submit.
    * -------------------------------------------------------------------------------- */
   form.on('submit', function(e){
      console.log('form_submit()');
      
	  //Validate form submission.
      validate();
   });
   
   /* --------------------------------------------------------------------------------
    * Run server-side validations to validate form submission.
    * -------------------------------------------------------------------------------- */
   function validate(){
      console.log('validate()');
      
      var validated = true;
      
      $.ajax({
         async:		false,
         type:		"POST",
         url:		base_url+'AJAX/Validate',
         data:		{validations: get_validations()}
      })
      .done(function(data){
         //If data was returned, there are errors so set validated to false; otherwise set validated to true.
         if (data!='') {
            console.log('Validations failed!');
            validated=false;
         }
      })
      .fail(function(xhr, status, error){
         console.log('Form Validation Error: '+xhr.responseText);
      });
      
      return validated;
   }
   
   /* --------------------------------------------------------------------------------
   * Get any fields that require server-side validation.
   * -------------------------------------------------------------------------------- */
   function get_validations(){
      console.log('get_validations()');
      
      //Create a validation object.
      var Validations={
         'required':		{},
      };
      
      //Loop through each element that needs to be validated.
      form.find('[data-required]').each(function(){
         //Get some information for each element being processed.
         var field_name       = $(this).attr('name');
         var field_value      = $(this).val();
         var field_label      = $(this).attr('data-label');
         if(typeof(field_label)=='undefined'){
            field_label='';
         }
         
         //If the required attribute is defined, set required to true.
         var field_required   = $(this).attr('data-required');
         if(typeof(field_required)!='undefined'){
            Validations['required'][field_name]={
               'value':	field_value,
               'label':	field_label
            }
         }
      });
      
      return JSON.stringify(Validations);
   }
   
   $('[data-confirm]').on('click', function(e){
      var confirm_message=$(this).attr('data-confirm');
      if(typeof(confirm_message)!='undefined'){
         if(confirm(confirm_message)===false){
            return false;
         }
      }
      return true;
   });

   /* --------------------------------------------------------------------------------
    * Automatically add leading 0's to fields that should be numeric.
    * -------------------------------------------------------------------------------- */
   $("[data-numeric],[data-day]").blur(function(){
      if($(this).val()!=''){
         max=$(this).attr("maxlength");
         neg=max-(max*2);
         zeros='';
         count=0;
         
         while(count<max){
            zeros=zeros+'0';
            count++;
         }
         
         var num=zeros+$(this).val();
         
         num=num.slice(neg);
         $(this).val(num);
         
         if($.isNumeric($(this).val())==false){
            alert(numeric_error)
            $(this).val('');
            $(this).focus();
         }
      }
   });
   
   /* --------------------------------------------------------------------------------
    * The [data-numeric] attribute determines if a field contains a valid numeric value.
    * -------------------------------------------------------------------------------- */
   $("[data-numeric]").keyup(function(){
      if($(this).val()!=''){
         if($.isNumeric($(this).val())==false){
            $(this).val('');
            alert(numeric_error);
            $(this).focus();
         }
      }
   });
   
   /* --------------------------------------------------------------------------------
	* Add the "data-day" attribute to an element to determine if the field
	* contains a valid day value.
	* -------------------------------------------------------------------------------- */
   $("[data-day]").keyup(function(e){
	  if(this.value.length=='2'){
		 if ($.isNumeric($(this).val())==false) {
			alert(day_error);
			$(this).val('');
			$(this).focus();
		 }else{
			if ($(this).val()>31 || $(this).val()<1){
			   alert(day_error);
			   $(this).val('');
			   $(this).focus();
			}
		 }
	  }
   });
   
   /* --------------------------------------------------------------------------------
	* If a month checkbox is checked, mark the month (hidden) field as "Y".
	* This means that this bill only needs to be checked for the specified months.
	* If none of the months are checked, the bill should be displayed for ALL months,
	* and the month (hidden) field should be marked as "N".
	* -------------------------------------------------------------------------------- */
   $("[data-month]").on('click', function(){
	  var month="N";
	  if($(this).prop('checked')===true){
		 month="Y";
	  }else{
		 $("[data-month]").each(function(){
			//alert('month = '+$(this).attr('name'));
			if($(this).prop('checked')===true){
			   month="Y";
			   return false;
			}
			return true;
		 });
	  }
	  
	  $('input[name="month"]').val(month);
   });
   
   /* --------------------------------------------------------------------------------
    * When a text field is focused, highlight all of the field's existing text automatically.
    * -------------------------------------------------------------------------------- */
   $("input[type=text]").focus(function() {
       $(this).select();
   });
   
   /* --------------------------------------------------------------------------------
    * Format a value as currency.
    * -------------------------------------------------------------------------------- */
   $('.currency').formatCurrency();
  
});