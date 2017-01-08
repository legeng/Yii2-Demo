/*!
 * Ajax Crud 
 * =================================
 * Use for johnitvn/yii2-ajaxcrud extension
 * @author John Martin john.itvn@gmail.com
 */
$(document).ready(function () {
    //parse url query params
    var parseUrl = function(e , url) {
        var url = url || location.search;
        e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var t = new RegExp("[\\?&]" + e + "=([^&#]*)"), //[\\?&] 匹配第一个？号或&分割，[^&#]*匹配&分割和#(页面hash)
        a = t.exec(url);
        return null === a ? "" : decodeURIComponent(a[1].replace(/\+/g, " "))
    }
    // Create instance of Modal Remote
    // This instance will be the controller of all business logic of modal
    // Backwards compatible lookup of old ajaxCrubModal ID
    if ($('#ajaxCrubModal').length > 0 && $('#ajaxCrudModal').length == 0) {
        modal = new ModalRemote('#ajaxCrubModal');
    } else {
        modal = new ModalRemote('#ajaxCrudModal');
    }

    // Catch click event on all buttons that want to open a modal
    $(document).on('click', '[role="modal-remote"]', function (event) {
        event.preventDefault();

        //click row data
        var id = parseUrl('id' , $(this).attr('href')); //primary key
        var columns = $('tr[data-key="'+id+'"]').children('td[data-model-field]'); //tr > td
        var rowData = {
            id : id
        };
        columns.each(function(){
            if($(this).children().length != 0){
                rowData[$(this).data('modelField')] = $(this).find('button.kv-editable-value').text(); 
            }else{
                rowData[$(this).data('modelField')] = $(this).text(); 
            }
        })
        // Open modal
        modal.open(this, null , rowData);
    });

    // Catch click event on all buttons that want to open a modal
    // with bulk action
    $(document).on('click', '[role="modal-remote-bulk"]', function (event) {
        event.preventDefault();

        // Collect all selected ID's
        var selectedIds = [];

        // every column data
        var selectedData = [];


        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked){
                selectedIds.push($(this).val());
                var columns = $('tr[data-key="'+$(this).val()+'"]').children('td[data-model-field]'); //tr > td
                var rowData = {
                    id : $(this).val()
                };
                columns.each(function(){
                    if($(this).children().length != 0){
                        rowData[$(this).data('modelField')] = $(this).find('button.kv-editable-value').text(); 
                    }else{
                        rowData[$(this).data('modelField')] = $(this).text(); 
                    }
                })
                
               selectedData.push(rowData);
            }
        });
        
        if (selectedIds.length == 0) {
            // If no selected ID's show warning
            if (localStorage.getItem("show-message") == '1') {
                swal({
                    title: "没有选中",
                    text: '必须要选择项才可以使用此操作.',
                    type: "warning",
                    confirmButtonColor: localStorage.getItem("s-skin-color"),
                    confirmButtonText: "关闭"
                })
            }else{
                toastr.warning('你必须要选择项才可以使用此操作!');
            }

        } else {
            // Open modal
            modal.open(this, selectedIds , selectedData);//[{} , {}]
        }
    });
});