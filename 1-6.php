<?php
/*
 * Template Name: Dialog JSON-API Integration
 *
 *
 * */

get_header(); ?>

    <div id="main-content">
        <div class="container">
            <div class="row">
                
                <head>
                
                  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
                
                    <style>
    .alexa-body{
      background: #334453;
      padding-top: 50px;
    }
    .alexa-header{
      background: #253443;
      height: 70px;
      padding-top: 12px;
      color: #fff;
      font-size: 30px;
    }
    .alexa-header .alexa-box{
      color: #fff;
    }
    .alexa-footer{
      background: #253443;
      height: 70px;
      padding-top: 2px;
    }
    .alexa-section{
      height: auto;
      min-height: calc(100vh - 640px);
      background: #202a34;
      overflow-y: auto;
    }

    .alexa-row{
      display: flex;
      justify-content: space-around;
      margin: 10px 0;
    }

    .row-id{
      width: 50px;
      height: 50px !important;
      text-align: center;
      background: #324255;
      border: none;
      border-radius: 50% !important;
      color: #fff;
      text-align: center;
    }

    .alexa-box{
      width: 27%;
      height: 50px;
      border: none;
      border-radius: 4px;
      padding-left: 10px;
      color: #ffffff;
      
    }
    .hs, .as, .ad{
      background: #5384ff;
    }
    
    #hs-dropdown, #as-dropdown, #ad-dropdown{
      display: none;
      width: 28%;
      background: #8492af;
      position: absolute;
      border-radius: 3px;
      padding: 10px 5px;
      box-shadow: 5px 5px 10px;
    }
    #as-dropdown p, #ad-dropdown p, #hs-dropdown p{
      margin: 0;
      padding-left: 8px;
      padding-right: 8px;
    }

    #as-dropdown p:hover, #ad-dropdown p:hover, #hs-dropdown p:hover{
      background: #65a8fe;
      padding-left: 10px;
      padding-right: 10px;
    }

    p.add-new{
      font-weight: bold;
      color: #000;
    }

    input{
      outline: none;
    }

    .add-input {
      background: transparent;
      border: 0;
      
      border-bottom: 1px solid #334453;
      margin-left: 10px;
    }
    #hs-items, #as-items, #ad-items{
     
    }
    .hs-item, .as-item, .ad-item{
      padding: 2px 0;
      position: relative;
    }
    .drop-close{
      float: right;
    }
    .human-delete{
      position: absolute;
      right: 0;
    }

    .hs-item:hover{
      background: #d7d7d7;
    }
    .hs-item{
      display: flex;
      justify-content: space-between;
    }
    .hs-item button{
      border: none;
      background: none;
      outline: none;
    }
    .hs-item button:hover{
      color: red;
      cursor: pointer;
    }
    .hs-item .edit{
      color: green;
    }
    .hs-item .delete{
      color: blue;
    }
    #hs-dropdown input{
      background: none;
      outline: none;
      border: none;
    }
    
    
    @media screen and (max-width:768px) {
    
    	.alexa-section{
        	padding-bottom:80px;
        }
    	.alexa-header{
        	height:50px;
            font-size:16px;            
        }
        
    	.row-id{
      		width: 30px;
     		height: 30px !important;      		
    	}

    	.alexa-box{
      		width: 29%;
      		height: 30px !important;
      		padding-left:0px;
            text-align:center;
    	}
    
    }

    
  </style>
</head>

<body class = "alexa-body">

  <div class="alexa-container container">

    <header class="alexa-header">

      <div class="alexa-row">
        <div class="row-id" style="visibility: hidden;"></div>
        <div class="alexa-box">Human says:</div>
        <div class="alexa-box">Al says:</div>
        <div class="alexa-box">Al does:</div>
      </div>

    </header>

    <section class="alexa-section">

      <div id="hs-dropdown" class="dropdown">
        <p class="add-new"> + Add New </p>
      </div>

      <div id="as-dropdown" class="dropdown">
      </div>

      <div id="ad-dropdown" class="dropdown">
        <p class="ad-item" idx="0">light on</p>
        <p class="ad-item" idx="1">light off</p>
        <p class="ad-item" idx="2">music streaming</p>
      </div>

    </section>

    <footer class="alexa-footer">

      <div class="row">
        <div class="col-8"></div>
        <div class="col-4 ">
          <button id="create_test" class="btn btn-primary btn-lg" style="display:block; margin:0 auto;">Execute</button>
        </div>
      </div>

    </footer>
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
<script>
    jQuery(document).ready(function ($) {

      var data = { boxes:[] };

      var i = 1;
      
      var alexa_contents = [];
     
      var selected_input;
      var row_id = 1;
    
      newRow(1, '');

      $('#create_test').click(function(){
        let str = JSON.stringify(data.boxes);
        
        str = str.replace(/"/g, "\\\"");
        str = str.replace(/[\?\!\.\']/g, " ");
        /* alert(str); */
        
        /**
        var nData = [];
        data.boxes.forEach( function(element, key){

          var jj = {"id":element.id, "action":element.action, "content": element.cases[0].content};
          nData.push(jj);
        });
        console.log(nData);
        **/
        
        var ajax_object = {"ajax_url":"http:\/\/noiman.com/\/wp-admin\/admin-ajax.php"};
        
		jQuery.get(ajax_object.ajax_url, {'action':'hello', 'param':data.boxes}, function(response) {
		    alert("result: " + response); 
		 });
         
      });

      /* Human Says DropDown */

      $(document).on('click', '.hs', function(){
        if( $('#hs-dropdown').css('display') == 'none'){
          $('.hs-item').remove();
          $('.add-input').remove();
          let box_id = $(this).attr('box_id');
          if( !$(this).hasClass('new') ){
            let items = data.boxes[box_id].cases;

            $.each(items, function (index, item){
            
              $('.add-new').before('<div class="hs-item" idx="' + items.indexOf(item) + '">' +
                                      '<input readonly="readonly" value="' + item.content + '">' + 
                                      '<div>' + 
                                        '<button class="edit">Edit</button>' + 
                                        '<!--<button class="delete">Delete</button>-->' +
                                      '</div>' +
                                    '</div>');
            });
          }
          if(!$('.add-input').length){
            $('#hs-dropdown').prepend('<input class="add-input" type="text">');
          }
          
          let offset = $(this).offset();
          let width = $('.alexa-box').width();
          let dropdown = $('#hs-dropdown');
          dropdown.animate({top: offset.top+ 53 - $('.sub_page_header').offset().top, left: offset.left, width: width}, 10, function(){ 
            $(this).slideDown(function(){
              $('#hs-dropdown .add-input').focus();
            });
          });
          selected_input = $(this);

        }
        
      });
      
      $(document).on('click', '.edit', function(e){
        e.preventDefault();
        $(this).parents('.hs-item').find('input').attr('readonly', false).focus();
      });
      

      $(document).on('click', '.delete', function(e){
        
        $(this).parents('.hs-item').remove();
        e.preventDefault();
      });
      

      $(document).on('click', '#hs-dropdown .hs-item input', function(e){
        if($(this).attr('readonly') == 'readonly'){
          selected_input.val($(this).val());
          selected_input.attr('idx', $(this).parent().attr('idx')) ;
          selected_input.trigger('change');
          $("#hs-dropdown").slideUp();
        }
      });
      

      $(document).on('change', '#hs-dropdown .hs-item input', function(e){
        $(this).attr('readonly','readonly');
        let box_id = selected_input.attr('box_id');
        let idx = $(this).parent().attr('idx');
        data.boxes[box_id].cases[idx].content = $(this).val();
          
      });
      

      $(document).on('change', '.hs', function(){
        if($(this).hasClass('new')){

          $(this).removeClass('new');
          $('.new').replaceWith('<div class="alexa-box"></div>');
          $('.dropdown').slideUp();
          row_id ++;
          newRow(row_id, 'hs');
          
          $('.as.new').trigger('click').focus();
          
        }else{
          $(this).parent('.alexa-row').nextAll('.alexa-row').remove();
          row_id = $(this).parent('.alexa-row').attr('rowid');
          showDialog( 'hs', $(this).attr('box_id'), $(this).attr('idx'));
        }
        
        $(this).blur();
      });

      $(document).click(function (e) {
          if (!$(e.target).hasClass("dropdown") && $(e.target).parents("#hs-dropdown").length === 0) 
          {
              $("#hs-dropdown").slideUp();
          }
      });

      $(document).on('click', '.add-new', function(){
        if(!$('.add-input').length){
           $('#hs-dropdown').prepend('<input class="add-input" type="text">');
        }
        
        $('.add-input').focus();
      });

      $(document).on('change', '.add-input', function(){
        let txt = $(this).val();

        $('.add-new').before('<div class="hs-item" idx="' + $('#hs-dropdown .hs-item').length + '">' +
                                    '<input readonly="readonly" value="' + txt + '">' + 
                                    '<div>' + 
                                      '<button class="edit">Edit</button>' + 
                                      '<!--<button class="delete">Delete</button>-->' +
                                    '</div>' +
                                  '</div>');
                                  

        if(!selected_input.attr('box_id')){
          selected_input.attr('box_id', data.boxes.length);
          data.boxes.push(
            {
              id: data.boxes.length, 
              action: 'hs',
              cases:[
                {
                  content: $(this).val(),
                  next: 0
                }
              ]
            });
          
          if(selected_input.parent('.alexa-row').attr('rowid') - 1){
            data.boxes[selected_input.parent('.alexa-row').prev().find('input.alexa-box').attr('box_id')].cases[0].next = data.boxes.length - 1;
          }
          
        }else{
          let box_id = parseInt(selected_input.attr('box_id'));
          data.boxes[box_id].cases.push({content: txt, next:0});
        }
        selected_input.val($(this).val());
        selected_input.attr('idx', $('#hs-dropdown .hs-item').length - 1) ;
        selected_input.trigger('change');

        $(this).remove();
      });

      /* Alexa Says DropDown */

      $(document).on('click', '.as', function(){
        if( $('#as-dropdown').css('display') == 'none'){
          $('#as-dropdown').html('');
          let items = data.boxes;
          alexa_contents = [];

          $.each(items, function (index, item){
            if(item.action == 'as'){
              $.each(item.cases, function(index, i_case){
                alexa_contents.push({box_id: item.id, content:i_case.content});
              });
            }
          });
          
          
          alexa_contents = $.unique(alexa_contents);
          
         
          $.each(alexa_contents, function(index, text){
            $('#as-dropdown').append('<p class="ad-item" idx="' + text.box_id + '">' + text.content + '</p>');
          });

          

          let offset = $(this).offset();
          let dropdown = $('#as-dropdown');
          let width = $('.alexa-box').width();
          dropdown.animate({top: offset.top+ 53 - $('.sub_page_header').offset().top, left: offset.left, width: width}, 10, function(){ $(this).slideDown()});
          selected_input = $(this);
        }
        
      });

      $(document).on('click', '#as-dropdown p', function(e){
        selected_input.val($(this).text());
        selected_input.attr('box_id', $(this).attr('idx'));
        $("#as-dropdown").slideUp();
        
        selected_input.siblings('.alexa-box').replaceWith('<div class="alexa-box"></div>');
        selected_input.parent('.alexa-row').nextAll('.alexa-row').remove();
        row_id = selected_input.parent('.alexa-row').attr('rowid');
        showDialog( 'as', $(this).attr('idx'), 0);
        
        let box_id = selected_input.parent('.alexa-row').prev().find('input.alexa-box').attr('box_id');
        let idx = selected_input.parent('.alexa-row').prev().find('input.alexa-box').attr('idx');
        data.boxes[box_id].cases[idx].next = selected_input.attr('box_id');
        
      });

      $(document).click(function (e) {
          if (!$(e.target).hasClass("dropdown") && $(e.target).parents("#as-dropdown").length === 0) 
          {
              $("#as-dropdown").slideUp();
          }
      });

      $(document).on('change', '.as', function(){
        if($(this).hasClass('new')){
          
            $(this).attr('box_id', data.boxes.length);

            data.boxes.push(
            {
              id: data.boxes.length, 
              action: 'as',
              cases:[
                {
                  content: $(this).val(),
                  next: 0
                }
              ]
            });
         
          $(this).removeClass('new');
          
          $('.new').removeClass('new').replaceWith('<div class="alexa-box"></div>');
          $('.dropdown').slideUp();
          if(data.boxes.length - 1){
           
            let box_id = $(this).parent('.alexa-row').prev().find('input.alexa-box').attr('box_id');
            let idx = $(this).parent('.alexa-row').prev().find('input.alexa-box').attr('idx');
            data.boxes[box_id].cases[idx].next = data.boxes.length - 1;
          }
          row_id ++;
          newRow(row_id, 'as');
          
        }else{
          let box_id = parseInt($(this).attr('box_id'));
          data.boxes[box_id].cases[0].content = $(this).val();
        }
        $(this).blur();
      });



      /* Alexa Does Dropdown */

      $(document).on('click', '.ad', function(){
        if( $('#ad-dropdown').css('display') == 'none'){

          let offset = $(this).offset();
          let dropdown = $('#ad-dropdown');
          let width = $('.alexa-box').width();
          dropdown.animate({top: offset.top+ 53 - $('.sub_page_header').offset().top, left: offset.left, width: width}, 10, function(){ $(this).slideDown()});
          selected_input = $(this);
        }
        
      });

      $(document).on('click', '#ad-dropdown p', function(e){
        selected_input.val($(this).text());
        selected_input.trigger('change');
        $("#ad-dropdown").slideUp();
      });

      $(document).click(function (e) {
          if (!$(e.target).hasClass("dropdown") && $(e.target).parents("#ad-dropdown").length === 0) 
          {
              $("#ad-dropdown").slideUp();
          }
      });

      $(document).on('change', '.ad', function(){
        if($(this).hasClass('new')){
         
            $(this).attr('box_id', data.boxes.length);

            data.boxes.push(
            {
              id: data.boxes.length, 
              action: 'ad',
              cases:[
                {
                  content: $(this).val(),
                  next: 0
                }
              ]
            });
          

          $(this).removeClass('new');
          
          $('.new').removeClass('new').replaceWith('<div class="alexa-box"></div>');
          $('.dropdown').slideUp();
          if(data.boxes.length - 1){
           
            let box_id = $(this).parent('.alexa-row').prev().find('input.alexa-box').attr('box_id');
            let idx = $(this).parent('.alexa-row').prev().find('input.alexa-box').attr('idx');
            data.boxes[box_id].cases[idx].next = data.boxes.length - 1;
          }
          row_id ++;
          newRow(row_id, 'ad');
          
           $('.hs.new').trigger('click');
          
        }else{
          let box_id = parseInt($(this).attr('box_id'));
          data.boxes[box_id].cases[0].content = $(this).val();
        }
        $(this).blur();
      });

      /* functions */

      function showDialog(action, box_id, idx){
        
        ++ row_id;
        box_id = data.boxes[box_id].cases[idx].next;
        while(box_id){
          action = data.boxes[box_id].action;
          let text = data.boxes[box_id].cases[0].content;
        
          createRow(row_id, box_id, action, text);
          box_id = data.boxes[box_id].cases[0].next;
          ++ row_id;
        }

        newRow(row_id, action);
        
        
      }

      function createRow(row_id, box_id, action, text){

        let row = '';
        let id_input = '<input class="row-id" type="text" value="' + row_id + '" disabled>';
        let empty_input = '<div class="alexa-box"></div>';
        let row_start = '<div class="alexa-row" rowid="' + row_id + '">';
        let row_end = '</div>';
        switch(action){
          case 'hs':
            row = row_start + id_input + '<input class="hs alexa-box" readonly="readonly" type="text" value="' + text + '" box_id="' + box_id + '"  idx="0">' + empty_input + empty_input + row_end;
            break;
          case 'as':
            row = row_start + id_input + empty_input + '<input class="as alexa-box" type="text" value="' + text + '" box_id="' + box_id + '"  idx="0">' + empty_input + row_end;
            break;
          case 'ad':
            row = row_start + id_input + empty_input + empty_input + '<input readonly="readonly"  class="ad alexa-box" type="text" value="' + text + '" box_id="' + box_id + '"  idx="0">' + row_end;
            break;
        }
        $('.alexa-section').append(row);
      }

      function newRow(id, action){
        let row = '';
        let id_input = '<input class="row-id" type="text" value="' + id + '" disabled>';
        let empty_input = '<div class="alexa-box"></div>';
        let row_start = '<div class="alexa-row" rowid="' + id + '">';
        let row_end = '</div>';
        let hs_input = '<input  readonly="readonly" class="hs alexa-box new" type="text" value="" idx="0">';
        let as_input = '<input class="as alexa-box new" type="text" value="" idx="0">';
        let ad_input = '<input  readonly="readonly" class="ad alexa-box new" type="text" value="" idx="0">';
        if(id == 1){
          row = row_start + id_input + hs_input + as_input + ad_input + row_end;
        }else{
          switch(action){
            case 'hs':
              row = row_start + id_input + empty_input + as_input + ad_input + row_end;
              break;
            case 'as':
              row = row_start + id_input + hs_input + empty_input + ad_input + row_end;
              break;
            case 'ad':
              row = row_start + id_input + hs_input + as_input + empty_input + row_end;
              break;
          }
        }
        
        $('.alexa-section').append(row);
        
        if($('.as.new').length){
          $('.as.new').focus();
        }else{
          $('.hs.new').trigger('click');
        }
        
      }

    });
  </script>
                
            </div>

        </div>

    </div>
<?php
get_footer();