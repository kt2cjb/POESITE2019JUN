jQuery( document ).ready(function(jQuery) {
	 $ = jQuery ;
	 
	 function fl_pie_circle_progressbar()
	 {

		   $('.easy_circle_progressbar').each( function(i){
				
				var bottom_of_object = $(this).offset().top + $(this).outerHeight();
				var bottom_of_window = $(window).scrollTop() + $(window).height();
				 
				 var prefix = $(this).data('prefix');
				 var suffix = $(this).data('suffix');
			     var source = $(this).data('source');
			     var gradiantcolorstart = $(this).data('gradiantcolorstart');
				 var gradiantcolorend = $(this).data('gradiantcolorend');
				 var enablescalecolor = $(this).data('enablescalecolor');
				 var value = $(this).data('value');
				 var enablecolor = $(this).data('enablecolor');

				
				/* If the object is completely visible in the window, fade it in */
		if(bottom_of_window > bottom_of_object){
			 if(enablecolor == 'value')
			{
				   trackColor  :  $(this).data('trackcolor');
		    }					
			
           if(enablescalecolor == 'value')
			{
				   scaleColor  :  $(this).data('scalecolor');
		    }						
		if(source == 'gradiant_link'){

	$(this).easyPieChart({
	 barColor: function(percent) {
    var ctx = this.renderer.getCtx();
    var canvas = this.renderer.getCanvas();
    var gradient = ctx.createLinearGradient(0,0,canvas.width,0);
        gradient.addColorStop(0, gradiantcolorstart);
        gradient.addColorStop(1, gradiantcolorend );
    return gradient; 
  },	

				  // barColor    :  $(this).data('barcolor'),
		           scaleColor  :  $(this).data('scalecolor'),
				   lineWidth   :  $(this).data('linewidth'),
				   size        :  $(this).data('size'),
				   trackColor  :  $(this).data('trackcolor'),
				   lineCap     :  $(this).data('linecap'),
				   rotatecolor :  $(this).data('rotatecolor'),
				   prefix      :  $(this).data('prefix'),
				   font_size   :  $(this).data('fontsize'),
				   suffix      :  $(this).data('suffix'),
				   trackWidth  :  $(this).data('trackwidth'),
				
				 easing:  $(this).data('animate'),
				 animate: ({ duration:  $(this).data('duration'), enabled: true }),
				 onStep: function(from, to, percent) 
				 {
					$(this.el).find(".percent ").text( prefix + Math.round(percent)+suffix);
				 }
				  
				});
		
			   }
			   else{
				    $(this).easyPieChart({  
				   scaleColor  :  $(this).data('scalecolor'),
				   barColor    :  $(this).data('barcolor'),
				   lineWidth   :  $(this).data('linewidth'),
				   size        :  $(this).data('size'),
				   trackColor  :  $(this).data('trackcolor'),
				   lineCap     :  $(this).data('linecap'),
				   rotatecolor :  $(this).data('rotatecolor'),
				   prefix      :  $(this).data('prefix'),
				   font_size   :  $(this).data('fontsize'),
				   suffix      :  $(this).data('suffix'),
				   trackWidth  :  $(this).data('trackwidth'),
				
				 easing:  $(this).data('animate'),
				 animate: ({ duration:  $(this).data('duration'), enabled: true }),
				 onStep: function(from, to, percent) 
				 {
					$(this.el).find(".percent ").text( prefix + Math.round(percent)+suffix);
				 }
				 
					});
				   
				   }
              }		
			});

   }
	 
	 $(window).scroll( function(){
		 fl_pie_circle_progressbar()
		 });
		 
fl_pie_circle_progressbar();
   
});