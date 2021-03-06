<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<form role="role" class="form-horizontal form-groups-bordered" method="post"
      action="<?= $view->action('savelayout', isset($attributeForm) ? $attributeForm->getID() : false) ?>">

    <input type="hidden" name="layout_attributes" class="layout_attributes" value="<?php  json_encode($selectedAttributes); ?>">


    <div class="row panel panel-default panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">
                <?= t('Edit Layout') ?>
            </div>
        </div>
        <div  class="col-md-9 col-sm-9 col-xs-9" id="mycanvas">



            <?php if($selectedAttributes->formPages){ ?>
                <?php
                foreach ($selectedAttributes->formPages as $row => $formPageRow){
                    if($formPageRow) {
                        echo '<div class="row-fluid gm-editing ui-sortable" data-row-id="' . $row . '">';
                        foreach ($formPageRow as $col => $formPageCol) {
                            echo '<div class="' . $formPageCol->columnClass . '" data-column-id="' . $col . '">';

                            foreach ((array)$formPageCol as $key => $formPage) {
                                if (is_array($formPage)) {
                                    foreach ($formPage as $i => $attr) {
                                        if($attr) {
                                            if ($attr->label) {
                                                echo '<!--gm-editable-region--><p class="editable-label list-group-item" data-page-index="' . $key . '">' . htmlspecialchars($attr->akName) . '</p><!--/gm-editable-region-->';
                                            } else {
                                                echo '<!--gm-editable-region--><div data-value="' . $attr->akID . '" data-athandle="' . $attr->atHandle . '" class="list-group-item ui-draggable ui-draggable-handle" data-page-index="' . $key . '" data-sort-order="" >';
                                                echo $attr->akName;
                                                echo '<br>';
                                                echo "<span>";
                                                foreach ($attributeOptions as $opts => $optKeys) {

                                                    if ($opts == $formPage[$i]->atHandle) {
                                                        foreach ($optKeys as $optKey => $opt) {
                                                            $optText = $opt['text'];
                                                            if (!$formPage[$i]->options) {
                                                                $formPage[$i]->options = (object)[];
                                                                $formPage[$i]->options->$optKey = false;
                                                            }
                                                            echo '<label class="control-label" style="font-weight:normal;">';
                                                            if ($formPage[$i]->options->$optKey) {
                                                                echo '<input type="checkbox" data-name="' . $optKey . '" class="attribute-option" value="1" checked="checked" />';
                                                            } else {
                                                                echo '<input type="checkbox" data-name="' . $optKey . '" class="attribute-option" value="1"  />';
                                                            }
                                                            echo '<span>' . $optText . '</span></label> <br>';
                                                        }
                                                    }
                                                }
                                                if ($attr->required) {
                                                    echo '<input type="checkbox" class="attribute-required" value="1" checked="checked" /> ' . t('Mandatory') . '&nbsp;&nbsp;&nbsp';
                                                } else {
                                                    echo '<input type="checkbox" class="attribute-required" value="1" /> ' . t('Mandatory') . '&nbsp;&nbsp;&nbsp';
                                                }
                                                echo '<a title="Remove Attribute" class="pull-right gm-removeAttr"><span class="fa fa-trash-o"></span></a>';

                                                echo '</span>';

                                                echo '</div><!--/gm-editable-region-->';
                                            }
                                        }
                                    }
                                }
                            }
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                }
                ?>
            <?php }  ?>


        </div>

        <div class="col-md-3 col-sm-3 col-xs-3 ">
            <h2>Available Attributes</h2>
            <p>Drag the attribute into your form :</p>
            <div class="list-group" id="draggableAttr">
                <?php
                    foreach($attributeKeys as $atKey =>$atOption){
                        echo '<div data-value="'.$atOption->akID.'" data-athandle="'.$atOption->atHandle.'" class="list-group-item">'.$atOption->akName.'</div>';
                    }
                ?>
            </div>
        </div>

    </div>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?=$view->action('');?>" class="pull-left btn btn-default"> <?=t('Back');?> </a>
            <button class="pull-right btn btn-success" type="submit" > <?= t('Save') ?> </button>
        </div>
    </div>
</form>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script type="text/template" class="attributes-template">

        <% if(rc.attributesData.formPages[rc.dataRowId]){ %>

            <% _.each( rc.attributesData.formPages[rc.dataRowId][rc.dataColumnId], function( page, i ){ %>

                <% _.each( page, function( attribute, j ){ %>
                    <% if($.type(attribute) == 'object'){  %>

                        <% if(attribute.label){ %>
                            <p class="editable-label list-group-item"  data-page-index="<%- i %>"><%- attribute.akName %><br></p>
                        <% }else{ %>
                            <div data-value="<%- attribute.akID %>" data-athandle="<%- attribute.atHandle %>" class="list-group-item ui-draggable ui-draggable-handle" data-page-index="<%- i %>" data-sort-order="" >
                                <%- attribute.akName %><br>
                                <span>
                                    <% if($.type(rc.attributeOptions[attribute.atHandle]) != 'undefined'){ %>
                                    <% _.each( rc.attributeOptions[attribute.atHandle], function( opt, optKey ){
                                            var optText = opt["text"];

                                            if($.type(rc.attributesData.formPages[rc.dataRowId][rc.dataColumnId][i][j].options) == 'undefined'){
                                                rc.attributesData.formPages[rc.dataRowId][rc.dataColumnId][i][j].options = {};
                                                rc.attributesData.formPages[rc.dataRowId][rc.dataColumnId][i][j].options[optKey] = false;
                                            }

                                        %>

                                            <label class="control-label" style="font-weight:normal;">
                                                <input type="checkbox" data-name="<%- optKey %>" class="attribute-option" value="1" <%- rc.attributesData.formPages[rc.dataRowId][rc.dataColumnId][i][j].options[optKey]?'checked="checked"':'' %> />
                                                <span><%- optText %></span>
                                            </label> <br>
                                        <% }); %>
                                    <% } %>

                                    <input type="checkbox" class="attribute-required" value="1" <%- attribute.required?'checked="checked"':'' %>/> <?= t('Mandatory') ?>&nbsp;&nbsp;&nbsp;
                                    <a title="Remove Attribute" class="pull-right gm-removeAttr"><span class="fa fa-trash-o"></span></a>
                                </span>
                            </div>
                        <% } %>
                    <% } %>
                <% }); %>
            <% }); %>
        <% } %>

</script>
<script type="text/javascript">


   $(document).ready(function () {

        /***Init Grid manager***/
       var gm = $("#mycanvas").gridmanager({
        rowClass:    "row-fluid",
        rowSelector: "div.row-fluid",
        debug:1,
       }).data('gridmanager');
       gm.attributeFormsApp.attributeOptions = <?= json_encode($attributeOptions) ?>;
       gm.attributeFormsApp.attributeKeys = <?= json_encode($attributeKeys) ?>;


       gm.attributeFormsApp.initDynamicDataView({
           attributeKeys: '',
           selectedAttributes: <?= json_encode($selectedAttributes) ?>,
           attributeOptions:'',
           buttn:'',
           dataRowId:'',
           dataColumnId:'',
           rowClass : '',
           columnClass :  ''
       });


       /* Draggable Attributes */
       $("#draggableAttr div").draggable({
           connectToSortable: ".column",
           helper: "clone",
           revert: "invalid",
           stop:function(){
           }
       });




       /*******Remove Row and bind click*******/
       $('#mycanvas').find('a.gm-removeRow').bind('click',function(event){
           event.preventDefault();
           var rowId = $(this).closest('.row-fluid').data('row-id');
           $(this).closest('.row-fluid').find('.column').each(function(){
               $(this).find('a.gm-removeCol').trigger('click');
           });
           delete gm.attributeFormsApp.data.attributesData.formPages[rowId];
           gm.attributeFormsApp.renderClosestAttributes(this);
       });



       /*******Remove column and bind click*******/
       $('#mycanvas').find('a.gm-removeCol').bind('click',function(event){
           event.preventDefault();
           var rowId = $(this).closest('.row-fluid').data('row-id'),
               columnId = $(this).closest('.column').data('column-id');
           $(this).closest('.column').find('.list-group-item').each(function(){
               $(this).find('.gm-removeAttr').trigger('click');
           });
           delete gm.attributeFormsApp.data.attributesData.formPages[rowId][columnId].columnClass;
           delete gm.attributeFormsApp.data.attributesData.formPages[rowId][columnId];
           gm.attributeFormsApp.renderClosestAttributes(this);
       });

       /*******Remove element/attribute and bind click*******/
       $('#mycanvas').find('a.gm-delete.fa.fa-times').bind('click', function(e) {

           gm.attributeFormsApp.removeEditableArea({
               attributeKeys: '',
               selectedAttributes: '',
               attributeOptions: '',
               attributeDiv: $(this).closest('.list-group-item'),
               dataRowId: $(this).closest('.row-fluid').data('row-id'),
               dataColumnId: $(this).closest('.column').data('column-id'),
               sortOrder:$(this).closest('.'+gm.options.gmEditRegion).find('.list-group-item').data('sort-order')
           });
           $(this).closest('.'+gm.options.gmEditRegion).remove();
           //$(this).closest('.list-group-item').remove();
           e.preventDefault();
       });

       /******Add sort order****/
       $('#mycanvas').find('.row-fluid').find('.column').each(function(i, el){
           $(this).find('.list-group-item').each(function(k, el){
               $(this).attr('data-sort-order',k);
           });
       });

       /***********Attribute mandatory / required change************/
       $('#mycanvas').on("change", ".attribute-required", function (event) {

           var rowId = $(this).closest('.row-fluid').data('row-id'),
               columnId = $(this).closest('.column').data('column-id'),
               sortOrderId = $(this).closest('.list-group-item').data('sort-order'),
               pageIndex = rowId+''+columnId;

           gm.attributeFormsApp.data
               .attributesData
               .formPages[rowId][columnId][pageIndex][sortOrderId]
               .required = $(this).is(':checked');
           gm.attributeFormsApp.updateFormData();

       });


       /*********** Attribute mandatory / required change ************/
       $('#mycanvas').on("change", ".attribute-option", function (event) {
           var dataRowId = $(this).closest('.row-fluid').data('row-id'),
               dataColumnId = $(this).closest('.column').data('column-id'),
               sortOrderId = $(this).closest('.list-group-item').data('sort-order'),
               pageIndex = dataRowId+''+dataColumnId;

           var attr = gm.attributeFormsApp.data.attributesData.formPages[dataRowId][dataColumnId][pageIndex][sortOrderId];
           var options = attr.options ? attr.options : {};

           var optionKey = $(this).data('name');
           if(gm.attributeFormsApp.data.attributeOptions) {
               var isUnique = gm.attributeFormsApp.data.attributeOptions[attr.atHandle][optionKey].unique;
           }else{
               var isUnique = gm.attributeFormsApp.attributeOptions[attr.atHandle][optionKey].unique;
           }

           if($(this).is(':checked') && isUnique){

               if($.type(gm.attributeFormsApp.data.attributesData.formPages[dataRowId][dataColumnId]) == 'object') {
                   $.each( gm.attributeFormsApp.data.attributesData.formPages[dataRowId][dataColumnId], function( i , page) {
                       if(i != 'columnClass'){
                           $.each( page, function( j , attribute) {
                               if (attribute.options) {
                                   attribute.options[optionKey] = false;
                               }
                           });
                       }
                   });
               }
           }
           options[optionKey] = $(this).is(':checked');
           gm.attributeFormsApp.data.attributesData
               .formPages[dataRowId][dataColumnId][pageIndex][sortOrderId]
               .options = options;
           if($(this).is(':checked') && isUnique){
               gm.attributeFormsApp.renderClosestAttributes(this);
           }else{
               gm.attributeFormsApp.updateFormData();
           }
       });


       /*********Label text change**********/
       $(document).on('blur keyup paste input', '[contenteditable]', function(){
           var dataRowId = $(this).closest('.row-fluid').data('row-id'),
               dataColumnId = $(this).closest('.column').data('column-id'),
               sortOrderId = $(this).find('p').closest('.list-group-item').attr('data-sort-order'),
               pageIndex = dataRowId+''+dataColumnId;

           var attr = gm.attributeFormsApp.data.attributesData.formPages[dataRowId][dataColumnId][pageIndex][sortOrderId];
           attr.akName = $(this).find('p').closest('.list-group-item').text();
           gm.attributeFormsApp.updateFormData();
       });

       /******Trigger click to fill hidden field****/
       $('#mycanvas').trigger('click');
    });

</script>