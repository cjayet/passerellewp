$(document).ready(function(){

    // chargement des tinyMCE
    if ( $('.loadTinyMCE').length ){
        loadTinyMCE('.loadTinyMCE');
    }


   /**
    * load "GridEditor"
    */
   $(document).on('click', '.load_grid_editor', function(){
       loadGridEditor();
   })

   $(document).on('change', '#select_list_elements', function(){
       loadGridEditor();
   })


    $(document).on('change', '#select_cms_lang', function(){
        $('#btn_load_arbo').trigger('click');
    })

    $(document).on('click', '.load_categories', function(){
        loadAllCategories();
    })

    $(document).on('change', '#select_list_categories', function(){
        $('#btn-load-category').trigger('click');
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
    * easycontent editor: affichage du preview du post (article/page) dans wordpress
    */
   $(document).on('click', '.preview_content', function(){
       previewContentInCMS( $(this) );
   })


    /**
     * réactive l'optimisation images/href
     */
    $(document).on('click', '.push_easycontent_cms', function(){
        setBoolContentUpdatedAndNotSaved(false);
    })


    /**
     *  Warning si non modal
     */
    $(document).on('click', '#btn_easycontent_optimiz_images, #btn_easycontent_optimiz_hrefs', function(){
        actionOnBtnOptimisationImagesHrefs( $(this) );
    })

})