<section style="min-height:calc(100vh - 83px)" class="light-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-4 col-lg-4 text-center">
				<div class="section-title">
					<h2>ÁREA RESTRITA</h2>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-5 col-lg-2 text-center">
				<div class="form-group">
					<a class="btn btn-link" href=""><i class="fa fa-user"></i></a>
					<a class="btn btn-link" href="restrict/logoff"><i class="fa fa-sign-out"></i></a>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_courses" role="tab" data-toggle="tab">Cursos</a></li>
			<li><a href="#tab_team" role="tab" data-toggle="tab">Equipe</a></li>
			<li><a href="#tab_user" role="tab" data-toggle="tab">Usuários</a></li>
		</ul>

		<div class="tab-content">

			<div id="tab_courses" class="tab-pane active">
				<div class="container-fluid">
					<h2 class="text-center">Gerenciar Cursos</h2>
					<a class="btn btn-primary" id="btn_add_course"><i class="fa fa-plus">&nbsp; Adicionar Curso</i></a>
					<table id="dt_courses" class="table table-striped table-bordered">
						<hread>
							<tr class="tableheader"></tr>
							<th>Nome</th>
							<th>Imagem</th>
							<th>Duração</th>
							<th>Descrição</th>
							<th>Ações</th>
							</tr>
						</hread>
						<tbody>

						</tbody>
					</table>
				</div>
				<!--container-fluid-->
			</div>

			<div id="tab_team" class="tab-pane">
				<div class="container-fluid">
					<h2 class="text-center">Gerenciar Equipe</h2>
					<a class="btn btn-primary" id="btn_add_member"><i class="fa fa-plus">&nbsp; Adicionar Membro</i></a>
					<table id="dt_team" class="table table-striped table-bordered">
						<hread>
							<tr class="tableheader"></tr>
							<th>Nome</th>
							<th>Foto</th>
							<th>Descrição</th>
							<th>Ações</th>
							</tr>
						</hread>
						<tbody>

						</tbody>
					</table>
				</div>
				<!--container-fluid-->
			</div>
			<div id="tab_user" class="tab-pane">
				<div class="container-fluid">
					<h2 class="text-center">Gerenciar Usuários</h2>
					<a class="btn btn-primary" id="btn_add_user"><i class="fa fa-plus">&nbsp; Adicionar Usuário</i></a>
					<table id="dt_users" class="table table-striped table-bordered">
						<hread>
							<tr class="tableheader"></tr>
							<th>Login</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Ações</th>
							</tr>
						</hread>
						<tbody>

						</tbody>
					</table>
				</div>
				<!--container-fluid-->
			</div>
		</div>
	</div>
	<!-- /.container -->
</section>

<!-- Modal Cursos -->

<div class="modal fade" id="modal_course">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="submit" class="close" data-dismiss="modal">X</button>
				<h4 class="modal-title">Cursos</h4>
			</div>
			<div class="modal-body">
				<div id="form_course">
					<input type="hidden" name="course_id">
					<div class="form-group">
						<label class="col-lg-2 control-label">Nome</label>
						<div class="col-lg-10">
							<input type="text" id="course_name" name="course_name" class="form-control" maxlength="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Imagem</label>
						<div class="col-lg-10">

							<!-- Modificação -->
							<img src="" alt="" id="course_img_path" style="max-height:400px;max-height:400px" />
							<label class="btn btn-block btn-info">
								<i class="fa fa-upload"></i>&nbsp;&nbsp;Importa imagem
								<input type="file" id="btn_upload_course_img" accept="image/*" style="display:none">
							</label>
							<input id="course_img" name="course_img">
							<!-- <input type="file" accept="image/*" id="course_img" name="course_img" class="form-control"> -->
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Duração</label>
						<div class="col-lg-10">
							<input type="number" min="0" id="course_duration" name="course_duration" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Descrição</label>
						<div class="col-lg-10">
							<textarea type="text" min="0" id="course_description" name="course_description" class="form-control">

							</textarea>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group text-center">
						<button type="submit" id="btn_save_course" class="btn btn-primary">
							<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
						</button>
						<span class="help-block"></span>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Equipe -->

<div class="modal fade" id="modal_member">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="submit" class="close" data-dismiss="modal">X</button>
				<h4 class="modal-title">Membro</h4>
			</div>
			<div class="modal-body">
				<div id="form_member">
					<input type="hidden" name="member_id">
					<div class="form-group">
						<label class="col-lg-2 control-label">Nome</label>
						<div class="col-lg-10">
							<input type="text" id="member_name" name="member_name" class="form-control" maxlength="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Foto</label>
						<div class="col-lg-10">

							<!-- Modificação -->
							<img src="" alt="" id="member_img_path" style="max-height:400px;max-height:400px" />
							<label class="btn btn-block btn-info">
								<i class="fa fa-upload"></i>&nbsp;&nbsp;Importa foto
								<input type="file" id="btn_upload_member_img" accept="image/*" style="display:none">
							</label>
							<input id="member_img" name="member_img">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Descrição</label>
						<div class="col-lg-10">
							<textarea type="text" min="0" id="member_description" name="member_description" class="form-control">

							</textarea>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group text-center">
						<button type="submit" id="btn_save_member" class="btn btn-primary">
							<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
						</button>
						<span class="help-block"></span>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Usuários -->

<div class="modal fade" id="modal_user">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="submit" class="close" data-dismiss="modal">X</button>
				<h4 class="modal-title">Usuário</h4>
			</div>
			<div class="modal-body">
				<div id="form_user">
					<input type="hidden" name="user_id">
					<div class="form-group">
						<label class="col-lg-2 control-label">Login</label>
						<div class="col-lg-10">
							<input type="text" id="user_login" name="user_login" class="form-control" maxlength="30">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Nome Completo</label>
						<div class="col-lg-10">
							<input type="text" id="user_full_name" name="user_full_name" class="form-control" maxlength="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">E-mail</label>
						<div class="col-lg-10">
							<input type="text" id="user_email" name="user_email" class="form-control" maxlength="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Confirmar E-mail</label>
						<div class="col-lg-10">
							<input type="text" id="user_email_confirm" name="user_email_confirm" class="form-control" maxlength="100">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Senha</label>
						<div class="col-lg-10">
							<input type="password" id="user_password" name="user_password" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Confirmar Senha</label>
						<div class="col-lg-10">
							<input type="password" id="user_password_confirm" name="user_password_confirm" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>


					<div class="form-group text-center">
						<button type="submit" id="btn_save_user" class="btn btn-primary">
							<i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
						</button>
						<span class="help-block"></span>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>