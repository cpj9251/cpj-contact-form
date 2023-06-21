/**************
JS File for CPJ COntact Form Plugin
Author: Paul Jarvis
Ver: 2.0.0
License: GPL GNU
 */

 jQuery(document).ready(function($){
 
        $("body").on('click','#cpj-contact-form-send-btn1',function(){
        
        let formOk = true;
       
        
        if($("#contact-form-name").val() === ''){
                  
            formOk = false;
            $("label[for=contact-form-name]").css('color','red');
            $("#contact-form-name").attr("placeholder","Please enter your name.");
            $("#contact-form-name").css("border-color","red");
            
            
        }
        if($("#contact-form-email").val() === ''){
                  
            formOk = false;
            $("label[for=contact-form-email]").css('color','red');
            $("#contact-form-email").attr("placeholder","Please enter your e-mail.");
             $("#contact-form-email").css("border-color","red");
          
        }
        if($("#contact-form-phone").val() === ''){
                   
            formOk = false;
            $("label[for=contact-form-phone").css('color','red');
            $("#contact-form-phone").css("border-color","red");
           $("#contact-form-phone").attr("placeholder","Please enter your phone.");
             
        }

        if(formOk){
        
                const formData = {
                                    'cpj-contact-form-nonce':cpj_ajax_obj.nonce,
                                    'action':'cpj_contact_form',
                                    'name':$("#contact-form-name").val(),
                                    'email':$("#contact-form-email").val(),
                                    'phone':$("#contact-form-phone").val(),
                                    'pref':$("#contact-form-pref-method").val(),
                                    'message':$("#contact-form-message").val()
                                 }
                $(".wp-block-cpj-contact-form-cpj-contact-form").html('<img id="ajax-loader" src="'+cpj_ajax_obj.ajax_loader_url+'">');

               $(".wp-block-cpj-contact-form-cpj-contact-form").load(cpj_ajax_obj.ajax_url,formData);
        
        }//end if

        
        
        });
 
        $("body").on("focus",".contact-form-input input",function(){
        
                $(this).css('border-color','#333333');

                let labelId = $(this).attr('id');

            

                $("label[for=" + labelId + "]").css('color','#333333');

        });

        $("#cpj_contact_form_admin_email_btn").click(function(){

        
                  const formData = {
                                    'cpj-contact-form-nonce':cpj_ajax_obj.nonce,
                                    'action':'cpj_contact_form_admin',
                                    'email':$("#cpj_contact_form_admin_email").val(),
                                    'message':$("#cpj_contact_form_response_text").val()
                                 }
                
                $("#cpj_contact_form_admin_email_response_block").load(cpj_ajax_obj.ajax_url,formData);
          
        
        });//end fx
 
 }); //end jquery doc ready