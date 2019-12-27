$(function () {
    var modal = { closable: false, autofocus: false, transition: 'fade down' };
    var dropdown = { allowAdditions: true, forceSelection: false, hideAdditions: false };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.masthead').visibility({
        once: false,
        onBottomPassed: () => {
            $('.fixed.menu').transition('fade in');
        },
        onBottomPassedReverse: () => {
            $('.fixed.menu').transition('fade out');
        }
    });

    $('.year').html(new Date().getFullYear());
    $('.ui.negative.message, .ui.positive.message').transition('fade', 4000);

    // account modal functions
    $('.add-account').click(function () {
        $('#accountModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown();
                    calendar('#birthdate'); dynamic('.school .ui.dropdown');
                    $('.department .ui.dropdown').dropdown({ placeholder: false });
                },
                onHide: () => {
                    $('#accountForm').form('clear');
                    $('#dob').val('01/01/1990');
                    $('#btnAccount').val('add');
                    window.location.assign('accounts');
                }
            })
        ).modal('show');
    });
    $('.edit-account').click(function () {
        var username = $(this).data('value');
        $.ajax({
            url: 'account/' + username + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#accountModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('#accountModal .title').html('Edit Account');
                            $('.username, .password').hide();
                            $('#userId').val(data.admin.user.user_id);
                            $('#adminId').val(data.admin.admin_id);
                            $('#username').val(data.admin.username);
                            $('#password').val(data.admin.password);
                            $('#password-confirm').val(data.admin.password);
                            $('#lastname').val(data.admin.user.last_name);
                            $('#firstname').val(data.admin.user.first_name);
                            $('#midname').val(data.admin.user.middle_name);
                            $('#gender').val(data.admin.user.gender);
                            $('#dob').val(data.admin.user.birth_date);
                            $('#school').val(data.admin.schools[0].name);
                            $('#department').append($('<option>', {
                                value: data.admin.departments[0].name,
                                text: data.admin.departments[0].name,
                                selected: true
                            }));
                            $('#role').val(data.admin.roles[0].name);
                            $('#btnAccount').val('update');
                            $('#btnAccount .label').html('Apply');
                            $('.ui.dropdown').dropdown();
                            calendar('#birthdate'); dynamic('.school .ui.dropdown');
                            $('.department .ui.dropdown').dropdown({ placeholder: false });
                        },
                        onHide: () => {
                            $('#accountForm').form('clear');
                            $('#dob').val('01/01/1990');
                            $('#btnAccount').val('add');
                            window.location.assign('accounts');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.mark-account').click(function () {
        var username = $(this).data('value');
        $.ajax({
            url: 'account/' + username + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markAccountModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var user = data.admin.user;
                            $('.username.holder').val(data.admin.username).html('Username: ' + data.admin.username);
                            $('.name.holder').html('Account Name: ' + user.first_name + ' ' + user.middle_name + '. ' + user.last_name);
                            $('.department.holder').html('Department: ' + data.admin.departments[0].name);
                            $('.school.holder').html('School: ' + data.admin.schools[0].name);
                        },
                        onHide: () => {
                            window.location.assign('accounts');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.delete-account').click(function () {
        window.location.assign('account/' + $('.username.holder').val() + '/delete');
    });
    // end account modal

    // school modal functions
    $('.add-school').click(function () {
        $('#schoolModal').modal(
            $.extend(modal, {
                onHide: () => {
                    window.location.assign('schools');
                }
            })
        ).modal('show');
    });
    $('.mark-school').click(function () {
        $.ajax({
            url: 'school/' + $(this).data('value') + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markSchoolModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.school.name').val(data.school.name).html('School Name: ' + data.school.name);
                        },
                        onHide: () => {
                            window.location.assign('schools');
                        }
                    })
                ).modal('show');
            },
            error: function (result) {
                console.log(result);
            }
        });
    });
    $('.delete-school').click(function () {
        window.location.assign('school/' + $('.school.name').val() + '/delete');
    });
    // end school modal

    // department modal functions
    $('.add-dept').click(function () {
        $('#deptModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown();
                },
                onHide: () => {
                    window.location.assign('departments');
                }
            })
        ).modal('show');
    });
    $('.mark-dept').click(function () {
        var arr = $(this).data('value');
        $.ajax({
            url: 'department/' + arr[0] + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markDeptModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.department.name').val(data.dept.name).html('Department Name: ' + data.dept.name);
                            $('.school.name').val(arr[1]).html('School: ' + arr[1]);
                        },
                        onHide: () => {
                            window.location.assign('departments');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.delete-dept').click(function () {
        window.location.assign('department/' + $('.department.name').val() + '/' + $('.school.name').val() + '/delete');
    });
    // end department modal

    // course modal functions
    $('.add-course').click(function () {
        $('#courseModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown();
                    dynamic('.school .ui.dropdown');
                },
                onHide: () => {
                    window.location.assign('courses');
                }
            })
        ).modal('show');
    });
    $('.edit-course').click(function () {
        var data = $(this).data('value');
        $.ajax({
            url: 'course/' + data[0] + '/' + data[1] + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#courseModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('#courseModal .title').html('Edit Course');
                            $('#school').val(data[3]);
                            $('#department').html('<option value="' + data[2] + '" selected>' + data[2] + '</option>')
                            $('#course').val(result.course.name);
                            $('#major').val(result.course.major);
                            $('.ui.dropdown').dropdown();
                            $('#btnCourse').val('update');
                            $('#btnCourse .label').html('Apply');
                        },
                        onHide: () => {
                            $('#courseForm').form('clear');
                            $('#btnCourse').val('add');
                            window.location.assign('courses');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.remove-course').click(function () {
        var data = $(this).data('value');
        $.ajax({
            url: 'course/' + data[0] + '/' + data[1] + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#markCourseModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.course.name').val(result.course.name).html('Course Name: ' + result.course.name);
                            $('.major.name').val(result.course.major).html('Major: ' + ((result.course.major === 'NONE') ? 'NONE' : result.course.major));
                            $('.department.name').val(result.course.departments[0].name).html('Department: ' + result.course.departments[0].name);
                            $('.school.name').val(result.course.schools[0].name).html('School: ' + result.course.schools[0].name);
                        },
                        onHide: () => {
                            window.location.assign('courses');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.delete-course').click(function () {
        window.location.assign('course/' + $('.course.name').val() + '/' + $('.major.name').val() + '/' + $('.department.name').val() + '/' + $('.school.name').val() + '/delete');
    });
    // end course modal

    // school year modal
    $('.add-sy').click(function () {
        $('#schoolYearModal').modal(
            $.extend(modal, {
                onHide: () => {
                    window.location.assign('school_years');
                }
            })
        ).modal('show');
    });
    $('.mark-sy').click(function () {
        $.ajax({
            url: 'school_year/' + $(this).data('value') + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markSyModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.sy.name').val(data.sy.school_year).html('School Year: ' + data.sy.school_year);
                        },
                        onHide: () => {
                            window.location.assign('school_years');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    $('.delete-sy').click(function () {
        window.location.assign('school_year/' + $('.sy.name').val() + '/delete');
    });
    // end school year modal

    // related job modal
    $('.add-job').click(function () {
        $('#jobModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.job .ui.dropdown').dropdown(dropdown);
                    $('.course .ui.dropdown').dropdown()
                },
                onApprove: () => {
                    $('#course').dropdown('get value')
                },
                onHide: () => {
                    window.location.assign('jobs');
                }
            })
        ).modal('show');
    });
    $('.mark-job').click(function () {
        var course = $(this).data('course').split(' - ');
        $.ajax({
            url: 'job/' + $(this).data('job') + '/mark',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.job').val(data.job.name).html('Job Name: ' + data.job.name);
                $('.course').val(course[0]).html('Course: ' + course[0]);
                $('.major').val(course[1]).html('Major: ' + course[1]);
                $('#markJobModal').modal(options);
            }
        });
    });
    $('.delete-job').click(function (e) {
        e.preventDefault();
        window.location.assign('job/' + $('.job').val() + '/' + $('.course').val() + '/' + $('.major').val() + '/delete');
    });
    // end related job

    // graduate modal
    $('.add-graduate').click(function (e) {
        e.preventDefault();
        $('#graduateModal').modal(options);
    });
    // end graduate modal

    replace('.btn-login');
    replace('.btn-profile');

    replace('.btn-account');
    replace('.btn-school');
    replace('.btn-dept');
    replace('.btn-course');
    replace('.btn-sy');
    replace('.btn-job');

    replace('.btn-report');
    replace('.btn-import');
    replace('.btn-graduate');
    replace('.btn-add');
    replace('.btn-task');

    $('#collapse-icon').addClass('fa-angle-double-left');
    $('[data-toggle=sidebar-collapse]').click(function () {
        $('.menu-collapsed').toggleClass('d-none');
        $('.sidebar-submenu').toggleClass('d-none');
        $('.submenu-icon').toggleClass('d-none');
        $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
        var a=$('.sidebar-separator-title');
        if(a.hasClass('d-flex')){
            a.removeClass('d-flex')
        }else{
            a.addClass('d-flex')
        }
        $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right')
    });
    $('.logout').click(function(e){
        e.preventDefault();
        $('#logout-form').submit();
    });
    $('.form-file-simple .inputFileVisible').click(function(){
        $(this).siblings('.inputFileHidden').trigger('click')
    });
    $('.form-file-simple .inputFileHidden').change(function(){
        var a=$(this).val().replace(/C:\\fakepath\\/i,'');
        $(this).siblings('.inputFileVisible').val(a)
    });
    $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function(){
        $(this).parent().parent().find('.inputFileHidden').trigger('click');
        $(this).parent().parent().addClass('is-focused')
    });
    $('.form-file-multiple .inputFileHidden').change(function(){
        var a='';
        for(var i=0;i<$(this).get(0).files.length;++i){
            if(i<$(this).get(0).files.length-1){
                a+=$(this).get(0).files.item(i).name+','
            }else{
                a+=$(this).get(0).files.item(i).name
            }
        }
        $(this).siblings('.input-group').find('.inputFileVisible').val(a)
    });
    $('.form-file-multiple .btn').on('focus',function(){
        $(this).parent().siblings().trigger('focus')
    });
    $('.form-file-multiple .btn').on('focusout',function(){
        $(this).parent().siblings().trigger('focusout')
    });
    /* $('input[name="dob"]').daterangepicker({singleDatePicker:true,showDropdowns:true,minYear:1970,maxYear:parseInt(moment().format('YYYY'),10)}); */

    function replace(a){$(a).click(function(e){e.preventDefault();window.location.replace($(this).data('target'))})}
    function calendar(a){$(a).calendar({type:'date',formatter:{date:(date)=>{if(!date)return'';var b=('0'+date.getDate()).slice(-2);var c=('0'+(date.getMonth()+1)).slice(-2);var d=date.getFullYear();return c+'/'+b+'/'+d}}})}
    function dynamic(a){$(a).dropdown({onChange:(value)=>{var b=$('input[name="_token"]').val();$.ajax({url:'department/fetch',method:'POST',data:{value:value,_token:b},success:(result)=>{$('#department').html(result)},error:(result)=>{console.log(result)}})}})}
});

