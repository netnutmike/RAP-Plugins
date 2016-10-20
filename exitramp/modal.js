(function($){ 
    var win = jQuery(window);
    var body = jQuery('body');
    var doc = jQuery(document);
    var __modals = [];
    var adjustBackground = function()
    {
        var vp = getViewport();
        for(var x in __modals)
        {
            if(__modals[x].background)
            {
                __modals[x].background.width(vp.width + vp.left);
                __modals[x].background.height(vp.height + vp.top); 
            }
        }
    }

    var centerModals = function()
    {
        var vp = getViewport();
        var modal;
        
        for(var x in __modals)
        {
            if(__modals[x].settings.autoCenter)
            {
                modal = __modals[x].modal;
                var mWidth = modal.width();
                var mHeight = modal.height();
                var offsetLeft = (vp.width - mWidth)/2;
                var offsetTop = (vp.height - mHeight)/2;
                var autoLeft = offsetLeft + vp.left;
                var autoTop = offsetTop + vp.top;
                if(autoLeft<0)
                  autoLeft = 0;
                if(autoTop < 0)
                  autoTop = 0;
                modal.data('top', offsetTop);
                modal.data('left', offsetLeft);
                //modal.css('top', autoTop + 'px');
                //modal.css('left', autoLeft + 'px');
                
                if(__modals[x].settings.lockPosition)
                {
                    if(modal.data('startLeft'))
                    {
                        var l = modal.data('startLeft');
                        modal.css('left', l + 'px');
                    }
                    else
                    {
                        modal.data('startLeft', autoLeft);
                    }
                    
                    if(modal.data('startTop'))
                    {
                        var t = modal.data('startTop');
                        modal.css('top', t + 'px');
                    }
                    else
                    {
                        modal.data('startTop', autoTop);
                    }
                }
            }
        }
    }
    
    var setModalPositions = function()
    {
        var vp = getViewport();
        var modal;
        for(var x in __modals)
        {
            if(!__modals[x].settings.lockPosition)
            {
                modal = __modals[x].modal;
                var mWidth = modal.width();
                var mHeight = modal.height();
                var relLeft = modal.data('left') + vp.left;
                var relTop = modal.data('top') + vp.top;
                var docWidth = doc.width();
                var docHeight = doc.height();
                
                if(relLeft + mWidth > docWidth)
                  relLeft = docWidth - mWidth;
                  
                if(relTop + mHeight > docHeight)
                  relTop = docHeight - mHeight;

                  if(relLeft < 0)
                    relLeft = 0;
                  if(relTop < 0)
                    relTop = 0;

                //modal.css('top', relTop + 'px');
                //modal.css('left', relLeft + 'px');
            }
        }
    }

    var modalRemove = function(e)
    {
        var indexToRemove = -1;
        for(var x=0;x<__modals.length;x++)
        {
            if(__modals[x] == e.data)
            {
                indexToRemove = x;
                __modals[x].modal.remove();
                if(__modals[x].background)
                  __modals[x].background.remove();
            }
        }
        if(indexToRemove >=0)
        {
            __modals.splice(indexToRemove, 1);
        }
    }
    
    var getViewport = function()
    {
        var vp = 
        {
            top:    win.scrollTop(),
            left:   win.scrollLeft(),
            width:  win.width(),
            height: win.height()
        }
        return vp;
    }
    
    var onScroll = function()
    {
        //adjustBackground();
        //setTimeout(adjustBackground, 50);
        //setModalPositions();
        //setTimeout(setModalPositions, 50);
    }
    
    var onResize = function()
    {
        adjustBackground();
        setTimeout(adjustBackground, 50);
        centerModals();
        setTimeout(centerModals, 50);
    }

    win.scroll(onScroll);
    win.resize(onResize);

    jQuery.fn.extend({   
        modal: function(options) {  
        
            var defaults = {
                autoCenter: true,
                lockPosition: false,
                background: null
            };
            
            var settings = jQuery.extend(defaults, options);
            

            return this.each(function() {  
                var obj = jQuery(this);
                var modal = {modal: obj, background: settings.background, settings: settings};
                if($.bgiframe)
                {
                  if(modal.background)
                    modal.background.bgiframe({ src: "BLOCKED SCRIPT'&lt;html&gt;&lt;/html&gt;';" });
                  modal.modal.bgiframe({ src: "BLOCKED SCRIPT'&lt;html&gt;&lt;/html&gt;';" });
                }
                modal.modal.bind('modalClosed', modal, modalRemove); 
                __modals.push(modal);
                body.prepend(modal.modal);
                //modal.modal.css('left', '');
                //modal.modal.css('top', '');
                modal.modal.data('left', modal.modal.offset().left);
                modal.modal.data('top', modal.modal.offset().top);
                if(modal.background)
                  body.prepend(modal.background);
                adjustBackground();
                //centerModals();
                //setModalPositions();
            });  
        },
        removeModal: function()
        {
            return this.each(function() {  
                var obj = jQuery(this);
                obj.trigger('modalClosed');
            });  
        }
    });  
})(jQuery);  


