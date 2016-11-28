(function($){
   $(document).ready(function(){

       /**
        * load "GridEditor"
        */
       $(document).on('click', '.load_grid_editor', function(){
           loadGridEditor();
       })

       /**
        * load arborescence
        */
       $(document).on('click', '.load_arborescence', function(){
           loadAllPostsPages();
       })


       $(document).on('click', '.inject_easycontent_content', function(){
           injectEasycontentContent();
       })


       /**
        *  Selection du texte + positionnement toolbar d'action
        */
       $(document).on('mouseup', '.ge-content.active', function(e){
           addEasycontentToolbarFromText();
       })

       /**
        * Search results for selected text
        */
       $(document).on('click', '.toolbar-menu-action span', function(){
           easycontentToolbarAction();
       });


       /**
        * Load random dummy image
        */
       $(document).on('click', '.load_random_images', function(){
           loadRandomDummyImage();
       })


       /**
        * Refresh image list
        */
       $(document).on('click', '.refresh_images', function(){
           refreshImagesListInPost();
       })

       /**
        * Refresh links list
        */
       $(document).on('click', '.refresh_links', function(){
           refreshLiensListInPost();
       })

   })
})(jQuery)

