$(function () {
	$("#btn_add_course").click(function () {
		clearErrors();
		$("#form_course")[0].reset();
		$("#course_img_path").attr("src", "");
		$("#modal_course").modal();
	});

	$("#btn_add_member").click(function () {
		clearErrors();
		$("#form_member")[0].reset();
		$("#member_photo_path").attr("src", "");
		$("#modal_member").modal();
	});

	$("#btn_add_user").click(function () {
		clearErrors();
		$("#form_user")[0].reset();
		$("#modal_user").modal();
	});

	$("#btn_upload_course_img").change(function () {
		uploadImg($(this), $("#course_img_path"), $("#course_img"));
	});

	$("#btn_upload_member_photo").change(function () {
		uploadImg($(this), $("#member_photo_path"), $("#member_photo"));
	});

	// SUBMISSÃO DO FORMULÁRIO CURSOS

	$("#form_course").submit(function (e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajaxsavecourse",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_course")
					.siblings(".help-block")
					.html(loadingImg("Verificando..."));
			},
			success: function (response) {
				clearErrors();
				if (response.status) {
					$("#modal_course").modal("hide");
					Swal.fire("Sucesso!","Curso salvo com sucesso!","success");
					dt_course.ajax.reload();
				} else {
					showErrorsModal(response.error_list);
				}
			},
		});
	});

	// SUBMISSÃO DO FORMULÁRIO MEMBER

	$("#form_member").submit(function (e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajaxsavemember",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_member")
					.siblings(".help-block")
					.html(loadingImg("Verificando..."));
			},
			success: function (response) {
				clearErrors();
				if (response.status) {
					$("#modal_member").modal("hide");
					Swal.fire("Sucesso","Ação executada com sucesso!","success");
					dt_team.ajax.reload();

				} else {
					showErrorsModal(response.error_list);
				}
			},
		});
	});

	// SUBMISSÃO DO FORMULÁRIO USUARIO

	$("#form_user").submit(function (e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajaxsaveuser",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function () {
				clearErrors();
				$("#btn_save_user")
					.siblings(".help-block")
					.html(loadingImg("Verificando..."));
			},
			success: function (response) {
				clearErrors();
				if (response.status) {
					$("#modal_user").modal("hide");
					Swal.fire("Sucesso","Usuário salvo com sucesso!","success");
					dt_users.ajax.reload();
				} else {
					showErrorsModal(response.error_list);
				}
			},
		});
	});

	// EDITA DADOS DO USUÁRIO LOGADO.
	$("#btn_your_user").click(function (e) {
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajaxgetuserdata",
			dataType: "json",
			data: { user_id: $(this).attr("user_id") },
			success: function (response) {
				clearErrors();
				$("#form_user")[0].reset();
				$.each(response.input, function (id, value) {
					$(`#${id}`).val(value);
				});
				$("#modal_user").modal();
			},
		});
	});

	function active_btn_course() {
		$(".btn-edit-course").click(function () {
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajaxgetcoursedata",
				dataType: "json",
				data: { course_id: $(this).attr("course_id") },
				success: function (response) {
					clearErrors();
					$("#form_course")[0].reset();
					$.each(response.input, function (id, value) {
						$(`#${id}`).val(value);
					});

					$("#course_img_path").attr("src", response.img.course_img_path);
					$("#modal_course").modal();
				},
			});
		});

		//Função para excluir course

		$(".btn-del-course").click(function () {

			course_id = $(this);
			
			Swal.fire({
				title:"Atenção!",	
				text:"Deseja deletar este curso?",	
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor:"#d9534f",
				confirmButtonText:"Sim",	
				cancelButtonText:"Não",
				showConfirmButton:true,
				showCloseButton:true,
			}).then((result)=>{
				if(result.value){
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajaxdeletecoursedata",
						dataType: "json",
						data: { course_id: course_id.attr("course_id") },
						success: function (response) {
							Swal.fire("Sucesso","Ação executada com sucesso!","success");
							dt_course.ajax.reload();
						},
					});
				}
			});		
		});
	}

	// CHAMANDO DATATABLE E PERSONALIZANDO - CURSOS

	var dt_course = $("#dt_courses").DataTable({
		"oLanguage":DATATABLE_PTBR,
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "restrict/ajaxlistcourse",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function () {
			active_btn_course();
		}
	});

	function active_btn_member() {
		$(".btn-edit-member").click(function () {
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajaxgetmemberdata",
				dataType: "json",
				data: { member_id: $(this).attr("member_id") },
				success: function (response) {
					clearErrors();
					$("#form_member")[0].reset();
					$.each(response.input, function (id, value) {
						$(`#${id}`).val(value);
					});

					$("#member_photo_path").attr("src", response.img.member_photo_path);
					$("#modal_member").modal();
				},
			});
		});

		//Função para excluir member

		$(".btn-del-member").click(function () {

			member_id = $(this);
			
			Swal.fire({
				title:"Atenção!",	
				text:"Deseja deletar este membro?",	
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor:"#d9534f",
				confirmButtonText:"Sim",	
				cancelButtonText:"Não",
				showConfirmButton:true,
				showCloseButton:true,
			}).then((result)=>{
				if(result.value){
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajaxdeletememberdata",
						dataType: "json",
						data: { member_id: member_id.attr("member_id") },
						success: function (response) {
							Swal.fire("Sucesso","Ação executada com sucesso!","success");
							dt_team.ajax.reload();
						},
					});
				}
			});		
		});
	}

	// CHAMANDO DATATABLE E PERSONALIZANDO - MEMBROS

	var dt_team = $("#dt_team").DataTable({
		"oLanguage":DATATABLE_PTBR,
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "restrict/ajaxlistmember",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function () {
			active_btn_member();
		},
	});

	// CHAMANDO DATATABLE E PERSONALIZANDO - USUARIOS

	function active_btn_user() {
		$(".btn-edit-user").click(function () {
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrict/ajaxgetuserdata",
				dataType: "json",
				data: { user_id: $(this).attr("user_id") },
				success: function (response) {
					clearErrors();
					$("#form_user")[0].reset();
					$.each(response.input, function (id, value) {
						$(`#${id}`).val(value);
					});

					$("#modal_user").modal();
				},
			});
		});

		//Função para excluir user

		$(".btn-del-user").click(function () {

			user_id = $(this);
			
			Swal.fire({
				title:"Atenção!",	
				text:"Deseja deletar este usuário?",	
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor:"#d9534f",
				confirmButtonText:"Sim",	
				cancelButtonText:"Não",
				showConfirmButton:true,
				showCloseButton:true,
			}).then((result)=>{
				if(result.value){
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrict/ajaxdeleteuserdata",
						dataType: "json",
						data: { user_id: user_id.attr("user_id") },
						success: function (response) {
							Swal.fire("Sucesso","Ação executada com sucesso!","success");
							dt_users.ajax.reload();
						},
					});
				}
			});		
		});
	}

	var dt_users = $("#dt_users").DataTable({
		"oLanguage":DATATABLE_PTBR,
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: {
			url: BASE_URL + "restrict/ajaxlistuser",
			type: "POST",
		},
		columnDefs: [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
        ],
        "drawCallback": function () {
			active_btn_user();
		},
	});
});
