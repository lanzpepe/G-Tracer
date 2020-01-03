$(function () {
    var modal = { closable: false, autofocus: false };
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

    $('.notify.toast').toast({
        showProgress: 'bottom',
        transition: {
            showMethod: 'fade left',
            hideMethod: 'fade left'
        }
    });

    $('.special.cards .image').dimmer({
        on: 'hover'
    });

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
                    window.location.assign('accounts');
                },
                onHidden: () => {
                    $('#accountForm').form('clear');
                    $('#dob').val('01/01/1990');
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
                            console.log(data);
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
                            $('#dept').append($('<option>', {
                                value: data.admin.departments[0].name,
                                text: data.admin.departments[0].name,
                                selected: true
                            }));
                            $('#role').val(data.admin.roles[0].name);
                            $('#btnAccount').val('updated');
                            $('#btnAccount .label').html('Apply');
                            $('.ui.dropdown').dropdown();
                            calendar('#birthdate'); dynamic('.school .ui.dropdown');
                            $('.department .ui.dropdown').dropdown({ placeholder: false });
                        },
                        onHide: () => {
                            window.location.assign('accounts');
                        },
                        onHidden: () => {
                            $('#accountForm').form('clear');
                            $('#dob').val('01/01/1990');
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
                    $('.school .ui.dropdown').dropdown();
                    $('.dept .ui.dropdown').dropdown(dropdown);
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
                    $('.school .ui.dropdown, .dept .ui.dropdown').dropdown();
                    $('.course .ui.dropdown, .major .ui.dropdown').dropdown(dropdown);
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
                            $('#dept').html('<option value="' + data[2] + '" selected>' + data[2] + '</option>')
                            $('#course').val(result.course.name);
                            $('#major').val(result.course.major);
                            $('.ui.dropdown').dropdown();
                            $('#btnCourse').val('updated');
                            $('#btnCourse .label').html('Apply');
                        },
                        onHide: () => {
                            window.location.assign('courses');
                        },
                        onHidden: () => {
                            $('#courseForm').form('clear');
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
                            $('.department.name').val(data[2]).html('Department: ' + data[2]);
                            $('.school.name').val(data[3]).html('School: ' + data[3]);
                        },
                        onHidden: () => {
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

    // school year modal functions
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

    // related job modal functions
    $('.add-job').click(function () {
        $('#jobModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.job .ui.dropdown').dropdown(dropdown);
                    $('.course .ui.dropdown').dropdown();
                },
                onApprove: () => {
                    $('#course').dropdown('get value');
                },
                onHide: () => {
                    window.location.assign('jobs');
                }
            })
        ).modal('show');
    });
    $('.mark-job').click(function () {
        var data = $(this).data('value');
        $.ajax({
            url: 'job/' + data[2] + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#markJobModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.job.name').val(result.job.name).html('Job Name: ' + result.job.name);
                            $('.course.name').val(data[0]).html('Course: ' + data[0]);
                            $('.major.name').val(data[1]).html('Major: ' + data[1]);
                        },
                        onHide: () => {
                            window.location.assign('jobs');
                        }
                    })
                ).modal('show');
            }
        });
    });
    $('.delete-job').click(function (e) {
        e.preventDefault();
        window.location.assign('job/' + $('.job.name').val() + '/' + $('.course.name').val() + '/' + $('.major.name').val() + '/delete');
    });
    // end related job

    // graduate modal functions
    $('.add-graduate').click(function () {
        $('#graduateModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown();
                    image('#image');
                },
                onHide: () => {
                    window.location.assign('graduates');
                },
                onHidden: () => {
                    $('#graduateForm').form('clear');
                }
            })
        ).modal('show');
    });
    $('.edit-graduate').click(function () {
        var id = $(this).data('value');
        $.ajax({
            url: 'graduate/' + id + '/mark',
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#graduateModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('#graduateModal .title').html('Update Graduate Data');
                            $('#sy').val(result.graduate.school_year);
                            $('#batch').val(result.graduate.batch);
                            $('#lastname').val(result.graduate.last_name);
                            $('#firstname').val(result.graduate.first_name);
                            $('#midname').val(result.graduate.middle_name);
                            $('#gender').val(result.graduate.gender);
                            $('#course').val(result.graduate.degree);
                            $('#major').val(result.graduate.major);
                            $('#temp').val(result.graduate.graduate_id);
                            image('#image');
                            $('.ui.dropdown').dropdown();
                            $('#btnGraduate').val('updated');
                            $('#btnGraduate .label').html('Apply');
                        },
                        onHide: () => {
                            window.location.assign('graduates');
                        },
                        onHidden: () => {
                            $('#graduateForm').form('clear');
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    // end graduate modal

    // import modal functions
    $('.import-graduates').click(function () {
        $('#uploadModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown();
                },
                onHide: () => {
                    window.location.assign('import');
                }
            })
        ).modal('show');
    });
    // end import modal

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

    $('.logout').click(function(e){
        e.preventDefault();
        $('#logout-form').submit();
    });

    function replace(a){$(a).click(function(e){e.preventDefault();window.location.replace($(this).data('target'))})}
    function calendar(a){$(a).calendar({type:'date',formatter:{date:(date)=>{if(!date)return'';var b=('0'+date.getDate()).slice(-2);var c=('0'+(date.getMonth()+1)).slice(-2);var d=date.getFullYear();return c+'/'+b+'/'+d}}})}
    function dynamic(a){$(a).dropdown({onChange:(value)=>{var b=$('input[name="_token"]').val();$.ajax({url:'department/fetch',method:'POST',data:{value:value,_token:b},success:(result)=>{$('#dept').html(result)},error:(result)=>{console.log(result)}})}})}
    function image(a){$(a).change(function(e){loadImage(e.target.files[0],(canvas)=>{var a=canvas.toDataURL('image/jpeg');a.replace(/^data\:image\/\w+\;base64\,/,'');$('#preview').attr('src',a)},{canvas:true,orientation:true})})};
});

