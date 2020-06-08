$(function () {
    var dropdown = { allowAdditions: true, forceSelection: false, hideAdditions: false };
    var modal = { closable: false, autofocus: false };
    var options = { clearable: true };
    var base = window.location.origin;
    var href = window.location.href;
    var date = new Date();

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

    $('.year').html(date.getFullYear());
    $('.tabular.menu .item').tab();
    $('.ui.embed').embed();

    // notifications
    $('.notification .ui.dropdown').dropdown({
        onChange: () => {
            $.ajax({
                url: `${base}/notifications/read`,
                method: 'POST',
                data: {
                    id: $('.notification .ui.dropdown').dropdown('get value')
                },
                error: (result) => {
                    console.log(result);
                }
            });
        }
    });

    $('.notification').click(function () {
        $.ajax({
            url: `${base}/notifications`,
            method: 'POST',
            success: (result) => {
                $('.notifications').empty().html(result);
            },
            error: (result) => {
                console.log(result);
            }
        });
    });
    // end notifications

    $('.notify.toast').toast({
        transition: {
            showMethod: 'fade left',
            hideMethod: 'fade left'
        }
    });

    $('.special.cards .image').dimmer({
        on: 'hover'
    });

    $('.menu .browse').popup({
        inline: true,
        hoverable: true,
        position: 'bottom left'
    });

    if ($('.item').hasClass('active')) {
        $.ajax({
            url: `${base}/page`,
            method: 'POST',
            data: {
                title: $('title').text(),
                description: base,
                url: base
            }
        });
    }

    $.ajax({
        url: `${base}/pages`,
        method: 'GET',
        dataType: 'json',
        success: (result) => {
            var contents = [];

            $.each(result.pages, (k, v) => {
                contents.push({
                    title: v.title,
                    description: v.description,
                    url: v.url
                });
            });

            $('.ui.search').search({
                source: contents
            });
        }
    });

    $('#linkedin').dataTable({
        'order': [],
        'columnDefs': [
            {
                'targets': [0, 2, 5],
                'orderable': false
            }
        ]
    }).on('page.dt', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });

    // account modal functions
    $('.add-account').click(function () {
        $('#accountModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown(options);
                    calendar('#birthdate'); departments('.school .ui.dropdown');
                },
                onHide: () => {
                    window.location.assign(href);
                },
                onHidden: () => {
                    $('#accountForm').form('clear');
                    $('#dob').val('01/01/1990');
                }
            })
        ).modal('show');
    });
    $('.edit-account').click(function () {
        $.ajax({
            url: `accounts/${$(this).data('value')}/edit`,
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
                            $('#dept').append($('<option>', {
                                value: data.admin.departments[0].name,
                                text: data.admin.departments[0].name,
                                selected: true
                            }));
                            $('#role').val(data.admin.roles[0].name);
                            $('#btnAccount').val('updated');
                            $('#btnAccount .label').html('Apply');
                            $('.ui.dropdown').dropdown(options);
                            calendar('#birthdate'); departments('.school .ui.dropdown');
                        },
                        onHide: () => {
                            window.location.assign(href);
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
        $.ajax({
            url: `accounts/${$(this).data('value')}`,
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markAccountModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var user = data.admin.user;
                            $('.username.holder').val(data.admin.admin_id).html(`Username: ${data.admin.username}`);
                            $('.name.holder').html(`Account Name: ${user.first_name} ${user.middle_name} ${user.last_name}`);
                            $('.department.holder').html(`Department: ${data.admin.departments[0].name}`);
                            $('.school.holder').html(`School: ${data.admin.schools[0].name}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
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
        window.location.assign(`accounts/${$('.username.holder').val()}`);
    });
    // end account modal

    // school modal functions
    $('.add-school').click(function () {
        $('#schoolModal').modal(
            $.extend(modal, {
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.mark-school').click(function () {
        $.ajax({
            url: `schools/${$(this).data('value')}`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#markSchoolModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.school.name').val(result.school.id).html(`School Name: ${result.school.name}`);
                            $('#deleteForm').attr('action', `${base}/schools/${result.school.id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
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
        window.location.assign(`schools/${$('.school.name').val()}`);
    });
    // end school modal

    // department modal functions
    $('.add-dept').click(function () {
        $('#deptModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown(options);
                    $('.dept .ui.dropdown').dropdown(dropdown);
                    departments('.school .ui.dropdown');
                },
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.mark-dept').click(function () {
        var data = $(this).data('value').split('+');
        $.ajax({
            url: `departments/${data[0]}`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#markDeptModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var school = $.grep(result.dept.schools, (a) => {
                                return a.id == data[1];
                            });
                            $('.school.name').val(school[0].id).html(`School: ${school[0].name}`);
                            $('.department.name').val(result.dept.id).html(`Department Name: ${result.dept.name}`);
                            $('#deleteForm').attr('action', `${base}/departments/${result.dept.id}+${school[0].id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
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
        window.location.assign(`departments/${$('.department.name').val()}+${$('.school.name').val()}`);
    });
    // end department modal

    // course modal functions
    $('.add-course').click(function () {
        $('#courseModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown(dropdown);
                },
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.edit-course').click(function () {
        var data = $(this).data('value').split('+');
        $.ajax({
            url: `courses/${data[0]}/edit`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#courseModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var school = $.grep(result.course.schools, (a) => {
                                return a.id == data[2];
                            });
                            var dept = $.grep(result.course.departments, (a) => {
                                return a.id == data[1];
                            });
                            $('#courseModal .title').html('Edit Degree Program');
                            $('#school').val(school[0].name);
                            $('#dept').html(`<option value="${dept[0].name}" selected>${dept[0].name}</option>`);
                            $('#code').val(result.course.code);
                            $('#course').val(result.course.name);
                            $('#major').val(result.course.major);
                            $('.school .ui.dropdown').dropdown(options);
                            $('.ui.dropdown').dropdown(dropdown);
                            $('#btnCourse').val('updated');
                            $('#btnCourse .label').html('Apply');
                        },
                        onHide: () => {
                            window.location.assign(href);
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
    $('.mark-course').click(function () {
        var data = $(this).data('value').split('+');
        $.ajax({
            url: `courses/${data[0]}`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                console.log(result);
                $('#markCourseModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var school = $.grep(result.course.schools, (a) => {
                                return a.id == data[2];
                            });
                            var dept = $.grep(result.course.departments, (a) => {
                                return a.id == data[1];
                            });
                            $('.course.code').val(result.course.id).html(`Program Code: ${result.course.code}`);
                            $('.course.name').val(result.course.name).html(`Name: ${result.course.name}`);
                            $('.major.name').html(`Major: ${result.course.major}`);
                            $('#deleteForm').attr('action', `${base}/courses/${result.course.id}+${dept[0].id}+${school[0].id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
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
        window.location.assign(`courses/${$('.course.name').val()}+${$('.department.name').val()}+${$('.school.name').val()}`);
    });
    // end course modal

    // related job modal functions
    $('.add-job').click(function () {
        $('#jobModal').modal(
            $.extend(modal, {
                onShow: () => {
                    $('.ui.dropdown').dropdown(options);
                    $('.job .ui.dropdown').dropdown(dropdown);
                },
                onApprove: () => {
                    $('#course').dropdown('get value');
                },
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.mark-job').click(function () {
        var data = $(this).data('value').split('+');
        $.ajax({
            url: `jobs/${data[0]}`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#markJobModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            var course = $.grep(result.job.courses, (a) => {
                                return a.id == data[1];
                            });
                            $('.job.name').val(result.job.id).html(`Job Name: ${result.job.name}`);
                            $('.course.name').val(course[0].id).html(`Course: ${course[0].code}`);
                            $('#deleteForm').attr('action', `${base}/jobs/${result.job.id}+${course[0].id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
                        }
                    })
                ).modal('show');
            }
        });
    });
    $('.delete-job').click(function () {
        window.location.assign(`jobs/${$('.job.name').val()}+${$('.course.name').val()}`);
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
                    window.location.assign(href);
                },
                onHidden: () => {
                    $('#graduateForm').form('clear');
                }
            })
        ).modal('show');
    });
    $('.edit-graduate').click(function () {
        $.ajax({
            url: `graduates/${$(this).data('value')}/edit`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                $('#graduateModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('#graduateModal .title').html('Update Graduate Data');
                            $('#graduateModal .sy').val(result.graduate.academic.year);
                            $('#graduateModal .batch').val(result.graduate.academic.batch);
                            $('#lastname').val(result.graduate.last_name);
                            $('#firstname').val(result.graduate.first_name);
                            $('#midname').val(result.graduate.middle_name);
                            $('#address').val(result.graduate.contacts[0].address);
                            $('#graduateModal .gender').val(result.graduate.gender);
                            $('#graduateModal .course').val(result.graduate.academic.degree);
                            $('#graduateModal .major').val(result.graduate.academic.major);
                            $('#temp').val(result.graduate.graduate_id);
                            image('#image');
                            $('.ui.dropdown').dropdown(options);
                            $('#btnGraduate').val('updated');
                            $('#btnGraduate .label').html('Apply');
                        },
                        onHide: () => {
                            window.location.assign(href);
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
    $('.mark-graduate').click(function () {
        $.ajax({
            url: `graduates/${$(this).data('value')}`,
            method: 'GET',
            dataType: 'json',
            success: (result) => {
                var graduate = result.graduate;
                $('#markGraduateModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.graduate.name').val(graduate.graduate_id).html(`Name: ${graduate.first_name} ${graduate.middle_name} ${graduate.last_name}`);
                            $('.graduate.course').html(`Degree: ${graduate.academic.degree}`);
                            $('.graduate.school').html(`School: ${graduate.academic.school}`);
                            $('.graduate.sy').html(`Graduated: ${graduate.academic.batch} ${graduate.academic.year}`);
                            $('#deleteForm').attr('action', `${base}/graduates/${graduate.graduate_id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
                        }
                    })
                ).modal('show');
            },
            error: (result) => {
                console.log(result);
            }
        })
    });
    $('.delete-graduate').click(function () {
        window.location.assign(`graduates/${$('.graduate.name').val()}`);
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
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.import-linkedin').click(function () {
        $('#linkedInUploadModal').modal(
            $.extend(modal, {
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    // end import modal

    // reward modal functions
    $('.add-item').click(function () {
        $('#rewardModal').modal(
            $.extend(modal, {
                onHide: () => {
                    window.location.assign(href);
                }
            })
        ).modal('show');
    });
    $('.edit-item').click(function () {
        $.ajax({
            url: `rewards/${$(this).data('value')}/edit`,
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#rewardModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('#rewardModal .title').html('Edit Reward Item');
                            $('#_value').val(data.reward.id);
                            $('#name').val(data.reward.name);
                            $('#description').val(data.reward.description);
                            $('#points').val(data.reward.points);
                            $('#quantity').val(data.reward.admins[0].pivot.quantity);
                            $('#btnReward').val('updated');
                            $('#btnReward .label').html('Apply');
                        },
                        onHide: () => {
                            window.location.assign(href);
                        }
                    })
                ).modal('show');
            },
            error: (err) => {
                console.log(err);
            }
        });
    });
    $('.mark-item').click(function () {
        $.ajax({
            url: `rewards/${$(this).data('value')}`,
            method: 'GET',
            dataType: 'json',
            success: (data) => {
                $('#markRewardModal').modal(
                    $.extend(modal, {
                        onShow: () => {
                            $('.name.holder').val(data.reward.id).html(`Item name: ${data.reward.name}`);
                            $('#deleteForm').attr('action', `${base}/rewards/${data.reward.id}`);
                        },
                        onHide: () => {
                            window.location.assign(href);
                        }
                    })
                ).modal('show');
            },
            error: (err) => {
                console.log(err);
            }
        });
    });
    $('.delete-item').click(function () {
        window.location.assign(`rewards/${$('.name.holder').val()}`);
    })
    // end reward modal

    replace('.btn-login');
    replace('.graduates');

    $('.btn-logout').click(function () {
        $.ajax({
            url: `${base}/logout`,
            method: 'POST',
            success: () => {
                window.location.assign(`${base}/login`);
            },
            error: (result) => {
                console.log(result);
            }
        });
    });

    function replace(a){$(a).click(function(e){e.preventDefault();window.location.replace($(this).data('target'))})}
    function calendar(a){$(a).calendar({type:'date'})}
    function departments(a){$(a).dropdown({onChange:(value)=>{$.ajax({url:`${base}/departments/fetch`,method:'POST',data:{value:value},success:(result)=>{$('#dept').html(result)},error:(result)=>{console.log(result)}})}})}
    function image(a){$(a).change(function(e){loadImage(e.target.files[0],(canvas)=>{var a=canvas.toDataURL('image/jpeg');a.replace(/^data\:image\/\w+\;base64\,/,'');$('#preview').attr('src',a)},{canvas:true,orientation:true})})};
});

