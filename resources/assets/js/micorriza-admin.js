import {ifElementExistsThenLaunch} from './functions/dom';
import {menuTreeToggler} from './menu-tree-toggler.js';
import {alertsController} from './alerts-controller.js';
import {menuSelectedItem} from './menu-selected-item.js';
import {selectArrow} from './select-arrow';
import {discount_codes} from './discount_codes';

//vue
import {
    providers,
    categories,
    categoriesModalEdit,
    subcategories,
    subcategoriesModalEdit,
    subcategoriesCheckboxes,
    types,
    typesModalEdit,
    subtypes,
    subtypesModalEdit,
    subtypesCheckboxes,
    providersSelect,
    providersModal,
    providersModalEdit,
    productSections,
    productSectionsModalCreate,
    productSectionsModalEdit,
    productSkusModalEdit,
    productSkus,
    productSkusModalCreate,
    relatedProducts,
    relatedProductsModalCreate,
    bags,
    billingModalEdit,
    bagStatusModalEdit,
    pagesectionsModalCreate,
    pagesectionsModalEdit,
    pagesections,
    cashouts,
    cashoutStatusModalEdit,
} from './vue/components/simple-cruds.js';

import {mediaManager} from './vue/components/media-manager.js';
import {singleSku} from './vue/components/single-sku.js';
import {adminVue} from './vue/main/admin.js';
import {mainVue} from './vue/main-vue.js';

//componentes globales
import './vue/components/single-image';
import './vue/components/multi-images';

import {
        pages,
        pagesectionsCheckbox,
        pagesectionsSort,
        sectionProtected,
        sectionMultipleUnlimited,
        sectionMultipleLimited,
        sectionMultipleFixed,
        componentForm,
        currentPageSections
    } from './vue/components/pages-simple-cruds';


 $(document).ready(function() {

     var summernote = $('.summernote_JS');
     if (summernote.length > 0) {
        summernote.summernote({
            minHeight: 150,
             dialogsInBody: false,
    //          disableDragAndDrop: true,//No descomentar, destuye el Drag and Drop de Summernote
             toolbar: [
                   // [groupName, [list of button]]
                   ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                   ['para', ['ul', 'ol']],
                   ['insert', ['link',"hr"]],
                   ['Misc', ['undo', 'redo','codeview']]
             ]
        });
     }

	ifElementExistsThenLaunch ([
		['label.tree-toggler', menuTreeToggler, undefined, ['label.tree-toggler', 'ul.tree']],
		['#alerts__container', alertsController, 'init', []],

                        ['#admin-vue', mainVue, undefined, [adminVue, {
                            providers,
                            categories,
                            categoriesModalEdit,
                            subcategories,
                            subcategoriesModalEdit,
                            subcategoriesCheckboxes,
                            types,
                            typesModalEdit,
                            subtypes,
                            subtypesModalEdit,
                            subtypesCheckboxes,
                            providersSelect,
                            providersModal,
                            providersModalEdit,
                            singleSku,
                            mediaManager,
                            productSections,
                            productSectionsModalCreate,
                            productSectionsModalEdit,
                            productSkusModalEdit,
                            productSkus,
                            productSkusModalCreate,
                            relatedProducts,
                            relatedProductsModalCreate,
                            bags,
                            billingModalEdit,
                            bagStatusModalEdit,
                            mediaManager,
                            pages,
                            pagesectionsModalCreate,
                            pagesectionsModalEdit,
                            pagesections,
                            pagesectionsCheckbox,
                            pagesectionsSort,
                            sectionProtected,
                            sectionMultipleUnlimited,
                            sectionMultipleLimited,
                            sectionMultipleFixed,
                            currentPageSections,
                            cashouts,
                            cashoutStatusModalEdit,
                        }]],
	]);
});

$(window).on('load', function() {

    var dataTable = $('.dataTable_JS');
    if (dataTable.length > 0) {
        dataTable.DataTable({
            'ordering' : true,
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                     "sFirst":    "Primero",
                     "sLast":     "Último",
                     "sNext":     "Siguiente",
                     "sPrevious": "Anterior"
                },

                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    }


    //Estilos para dataTables, no se pueden modificar directamente

    function fixCol(elem, oldCol, newCol){
        elem.removeClass('col-'+oldCol).addClass('col-'+newCol);
    }

    var showRegister = $('.dataTables_length');
    fixCol(showRegister.parent(), 'sm-6', 'xs-5');

    showRegister.find('select').addClass('input__table-select--pagination');

    var tableSearch = $('.dataTables_filter');
    fixCol(tableSearch.parent(), 'sm-6', 'xs-5');

    var paginateInfo = $('.dataTables_info');
    fixCol(paginateInfo.parent(), 'sm-5', 'xs-4');

    var paginate = $('.dataTables_paginate ');
    fixCol(paginate.parent(), 'sm-7', 'xs-6');

    var inputSearch = $('input[type=search]');
    inputSearch.addClass('input__table-search');

    function tableCols() {
        var tableHead = $('#DataTables_Table_0');
        var cols = tableHead.find('th').length;

        if (cols >= 8) {
            $('#DataTables_Table_0_wrapper').addClass('cols-over-eight');
        }

    }

    tableCols();

    ['col-xs-5', 'col-xs-6', 'col-xs-4'].forEach((klass) => $('.dataTables_wrapper').removeClass(klass));

    $('.input-daterange input').each(function() {
      $(this).datepicker({format: 'yyyy-mm-dd'});
    });

    /*$('.collapsible-body_JS').hide();
    $('.routetd_JS').click(function(){
        $('.collapsible-body_JS').slideToggle('500');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash')
    });
*/

    $(".collapsible").on("click",".routetd_JS",function(e){
        console.log("click")
        $(this).closest("li").find(".infoshow_JS").toggleClass("hidden");
    })
});
