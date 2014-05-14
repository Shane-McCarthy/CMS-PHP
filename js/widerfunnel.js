/**
 * Created by Gui on 14/04/14.
 */

//function ajaxInit(url)
//{
//        $.ajax(
//            {
//                url: url,
//                success: function (result) {
//                    $('#mainContainer').html(result);
//                }
//            });
//}
//
//function clickMain() {
//
//    $(document).on('click', '[data-target="container"]', function (evt) {
//        var History = window.History;
//        var url = $(this).attr('href');
//        var num = null;
//        var value= null;
//        var project = undefined;
//
//        if ($(this).attr('id') != undefined) {
//            num = $(this).attr('id');
//            value = num.split('|')[0];
//            project = num.split('|')[1];
//        }
//        var address = window.location.href;
//        var param = address.split('.php/')[1];
//        if (param != null) {
//            History.pushState({someNum:$(this).attr('data-target'), numero:num, valor:value, proj:project, navigate:url}, null, (window.location.href).replace(param, "mainContainer"));
//        }
//        else {
//            History.pushState({someNum:$(this).attr('data-target'), numero:num, valor:value, proj:project, navigate:url}, null, location.href+'/mainContainer');
//        }
//
//
//        return false;
//
//    });
//}
//
//function ajaxMain(project, num, url, value)
//{
//
//    if (project == undefined && num != null) {
//        $.ajax(
//            {
//                url: url,
//                data: {projectID: num},
//                success: function (result) {
//                    $('#mainContainer').html(result);
//                }
//            });
//    }
//    else if (project != undefined) {
//        $.ajax(
//            {
//                url: url,
//                data: {taskID: value, projectID: project},
//                success: function (result) {
//                    $('#mainContainer').html(result);
//                }
//            });
//    }
//    else {
//        $.ajax(
//            {
//                url: url,
//                success: function (result) {
//                    $('#mainContainer').html(result);
//
//                }
//            });
//    }
//
//}
//
//
//
//function clickContainer() {
//    $(document).on('click', '[data-target="main"]', function (evt) {
//        var History = window.History;
//        var url = $(this).attr('href');
//        var num = null;
//        var value= null;
//        var project = undefined;
//
//        if ($(this).attr('id') != undefined) {
//            num = $(this).attr('id');
//            value = num.split('|')[0];
//            project = num.split('|')[1];
//        }
//
//        var address = window.location.href;
//        var param = address.split('.php/')[1];
//        if (param != null) {
//            History.pushState({someNum:$(this).attr('data-target'), numero:num, valor:value, proj:project, navigate:url}, null, (window.location.href).replace(param, "main"));
//        }
//        else {
//            History.pushState({someNum:$(this).attr('data-target'), numero:num, valor:value, proj:project, navigate:url}, null, location.href+'/main');
//        }
//        return false;
//    });
//}
//
//function ajaxContainer(project, num, url, value)
//{
//
//    if (project == undefined && num != null) {
//        $.ajax(
//            {
//                url: url,
//                data: {projectID: num},
//                success: function (result) {
//                    $('#container').html(result);
//                }
//            });
//    }
//    else if (project != undefined) {
//        $.ajax(
//            {
//                url: url,
//                data: {taskID: value, projectID: project},
//                success: function (result) {
//                    $('#container').html(result);
//                }
//            });
//    }
//    else {
//        $.ajax(
//            {
//                url: url,
//                success: function (result) {
//                    $('#container').html(result);
//                }
//            });
//    }
//}

function dropDownA() {
    $('#dropdown').on("change", function (evt) {
        $('#loading,#overlay').css('display', '');

        var url = window.location.href;
        var param = url.split('?')[1];
        if (param != null) {
            window.location.href = (window.location.href).replace(param, "projectID=" + this.value);
        }
        else {
            window.location.href = window.location.href + "?projectID=" + this.value;
        }
    });
}

function dropDownB() {
    $('#project_name').on("change", function (evt) {
        var value = this.value;
        var data = $(this).attr('data-value');
        $('#project').html(value);
        $('#identity').html(data);
    });
}

function modal() {
    $('[data-toggle="modal"]').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url,function (data) {
                $('<div class="modal hide fade">' + data + '</div>').modal();
            }).success(function () {
                    $('input:text:visible:first').focus();
                });
        }
    });
}

//function StateChange(){
//    if (History) {
//        // Bind to StateChange Event
//        History.Adapter.bind(window, 'statechange', function (evt) { // Note: We are using statechange instead of popstate
//
//            var State = History.getState(); // Note: We are using History.getState() instead of event.state, state.data gives what you have passed for customState parameter in pushState
//            if(State.data.someNum ==  'container')
//            {
//                ajaxMain(State.data.proj, State.data.numero, State.data.navigate, State.data.valor);
//            }
////            else if(State.data.numero == 'init' && State.data.someNum ==  'main')
////            {
////                ajaxInit(State.url);
////            }
//            else if(State.data.someNum ==  'main')
//            {
//                ajaxContainer(State.data.proj, State.data.numero, State.data.navigate, State.data.valor);
//            }
//            else
//            {
//                window.location.href='index.php';
//            }
//
//            })
//}
//}
function embedly(){
    $('.dropdown a').embedly({
        key: '163797294712423988af7b9c6abf1838',
        query: {maxwidth:200}
    });}

$(document).ready(function () {


    dropDownA();
    dropDownB();
    embedly();
    //History.pushState({someNum:$(this).attr('data-target'), numero:num, valor:value, proj:project}, null, $(this).attr('href'));
    //History.pushState({someNum:'main', numero:'init'}, null, '../../views/admin/edit_exp.php');

});


$( document ).ajaxStart(function() {
    $('#loading,#overlay').css('display', '');
});

$( document ).ajaxStop(function() {
    $('#loading,#overlay').css('display', 'none');
});

function changeHiddenInput (objDropDown)
{
    var objHidden = document.getElementById("activecollab_id");
    var objTwo = document.getElementById("identity");
    var value = objDropDown.value;
    value = value.split('|');
    var id = value[0];
    var name = value[1];
    objHidden.value = id;
    console.log(objDropDown.text);
    objTwo.value = name;

}


