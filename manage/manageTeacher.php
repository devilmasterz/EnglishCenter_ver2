<?php
require '../lib/functionTeacher.php';




$listTeacher = listTeacher($connection);
$listtk_gv = listtk_gv($connection);
$listClassOfTeacher = listClassOfTeacher($connection);
$listClassActive = listClassActive($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (isset($_POST['refesh'])) {
		header("Location: manageTeacher.php");
	}

	
}


$jsonListTeacher = json_encode($listTeacher);
$jsonListtk_gv = json_encode($listtk_gv);
$jsonListClass = json_encode($listClassOfTeacher);
$jsonlistClassActive = json_encode($listClassActive);



?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Quản lý hệ thống giáo dục</title>
	<link rel="stylesheet" href="../assets/css/manage.css">
	<link rel="stylesheet" href="../assets/css/mangeTeacher.css">
	<script src="https://code.jquery.com/jquery-3.6.4.js"></script>
</head>

<body>
	<header>
		<div class="logo">
			<img src="../assets/images/logo-web.png" alt="Logo">

		</div>
		<nav>
			<ul>
				<li><a href="./ListClass.php">Quản lý lớp học</a></li>
				<li><a href="../manage/manageStudent.php">Quản lý học sinh</a></li>
				<li><a style="color: #0088cc;" href="../manage/manageTeacher.php">Quản lý giáo viên</a></li>
				<li><a href="../manage/ManageParent.php">Quản lý phụ huynh</a></li>
				<li><a href="../manage/manageFinance.php">Quản lý tài chính</a></li>
				<li><a href="../manage/manageStatistical.php">Báo cáo thống kê</a></li>
				<li><a href="../pages/home/home.php" style="display: flex;"><img src="../assets/images/icon-logout.png" alt="" style="width:20px"></a></li>

			</ul>
		</nav>
	</header>
	<main>

		<h1>Quản lý Giáo viên</h1>
		<div class="search-container">
			<form id="form-search" method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="width: 50%; margin: unset;display: inline-flex;" autocomplete="off">
				<input type="text" name="keyword" id="keyword" placeholder="Tìm kiếm..." style="width: 70% ; border-radius: 0px; border-color:black;" value="<?php if (isset($_POST['keyword'])) {
																																								} ?>" oninput="searchList()">
				<input type="button" id="search" value="Tìm kiếm" style="width: 100px;  background-color: #4CAF50;">
				<button type="submit" id="refesh-btn" name="refesh" style=" background-color: currentcolor "> <img style="width: 30px;" src="../assets/images/Refresh-icon.png" alt=""></button>
			</form>


			<div>
				<button class="add-teacher-button">+ Thêm giáo viên</button>
			</div>
		</div>

		<table id="table-1">
			<thead>
				<tr>
					<th >STT</th>
					<th onclick="sortTable(1)">Mã Giáo viên</th>
					<th onclick="sortTable(2)">Họ tên</th>
					<th onclick="sortTable(3)">Giới tính</th>
					<th onclick="sortTable(4)">Tuổi</th>
					<th onclick="sortTable(5)">Địa chỉ</th>
				</tr>
			</thead>
			<tbody class="tbody-1">




			</tbody>
		</table>
		<div id="container-index"></div>
		<!-- Thong tin chi tiet -->
		<div class="modal-bg">
			<div class="modal-content">
				<h2>Thông tin giáo viên</h2>
				<button id="edit-button" style="position: absolute;top: 40px;right: 60px;">Sửa</button>

				<button id="delete-button" name="delete" style="position: absolute;top: 40px;right: 11px; background-color: #e90000">Xóa</button>

				<div class="container">

					<div class="header">
						<img id="img" alt="Avatar" class="avatar">

						<h1 class="name" id="teacher-name"></h1>
					</div>
					<div class="detail">

						<div class="tab">
							<button class="tablinks" id="tb1" onclick="openTab(event, 'tab1')">Chung</button>
							<button class="tablinks" id="tb2" onclick="openTab(event, 'tab2')">Lớp dạy</button>
							<button class="tablinks" id="tb3" onclick="openTab(event, 'tab3')">Tài khoản</button>
						</div>

						<div id="tab1" class="tabcontent">

							<table>
								<tr>
									<th>Mã giáo viên:</th>
									<td id="teacher-id"></td>
								</tr>
								<tr>
									<th>Giới tính:</th>
									<td id="teacher-gender" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Ngày sinh:</th>
									<td id="teacher-date" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Tuổi:</th>
									<td id="teacher-age" contenteditable="false">43</td>
								</tr>
								<tr>
									<th>Quê quán:</th>
									<td id="teacher-qq" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Địa chỉ:</th>
									<td id="teacher-address" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Trình độ:</th>
									<td id="teacher-qualification" contenteditable="false"></td>
								</tr>

								<tr>
									<th>Số điện thoại: </th>
									<td id="teacher-phone" contenteditable="false"></td>
								</tr>
								<tr>
									<th>Email:</th>
									<td id="teacher-email" contenteditable="false"></td>
								</tr>
							</table>

						</div>

						<div id="tab2" class="tabcontent">
							<div id="classes-of-teacher">

							</div>

						</div>


						<div id="tab3" class="tabcontent">
							<div>
								<table>
									<tr>
										<td id="date_logup"></td>
									</tr>
									<tr>
										<td>
											<h3 style="text-align: center;"> Tên đăng nhập : </h3>
										</td>
										<td>
											<label id="name-login"> </label>
										</td>
									</tr>
									<tr>
										<td>
											<h3 style="text-align: center;"> Mật khẩu : </h3>
										</td>
										<td>
											<input type="password" id="password" style="height: 21px;font-size: 18px;" readonly>
											<button style="background-color: slategray;" onclick="togglePassword()">Hiện/ẩn</button>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<button style=" background-color: peru;" id="change-pass-btn">Đổi mật khẩu</button>
										</td>
									</tr>
								</table>
							</div>
							<div id="div-change-pass">
								<form action="#" method="POST" id="change-pass" name="change-pass">
									<table>

										<tr>
											<td>
												<label> Tên đăng nhập : </label>
											</td>
											<td>
												<input type="text" id="username-login" name="username-login" readonly>
											</td>

										</tr>
										<tr>
											<td>
												<h5 id="err-username" style="color: red;font-style: italic;  font-size: 14px;"></h5>
											</td>

										</tr>
										<tr>

											<td>
												<label for="new-password">Mật khẩu mới:</label>
											</td>
											<td>
												<input type="password" id="new-password" name="new-password" autocomplete="false"><br>
											</td>
										</tr>
										<tr>
											<td>
												<h5 id="err-pass" style="color: red;font-style: italic;  font-size: 14px;"></h5>
											</td>

										</tr>


										<tr>
											<td style="text-align :center">
												<button type="button" id="cancle-change-pass" style=" font-size: 14px;padding: 14px 20px;">Hủy bỏ</button>
											</td>
											<td style="text-align :center">
												<input type="submit" name="change" id="change" style="width: unset" value="Cập nhật">
											</td>
										</tr>

									</table>
								</form>
							</div>
						</div>

					</div>

					<button class="close-btn">Đóng</button>
				</div>
			</div>
		</div>
		<!-- Sua thong tin -->
		<div class="modal-bg-edit">
			<div class="modal-content-edit">
				<div>
					<form id="form_edit" name="form_edit" method="post">


					
						<h1>Sửa thông tin giáo viên</h1>

						<h2 id="teacher-id_edit"></h2>
						<input type="hidden" id="id_edit" name="id_edit">

						<label for="teacher_name">Tên giáo viên: <label id="lb_name_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="teacher_name_edit" name="teacher_name_edit" required>

						<label for="gender">Giới tính:</label>
						<select id="gender_edit" name="gender_edit">
							<option>Nam</option>
							<option>Nữ</option>
						</select>

						<label for="birthday">Ngày sinh:</label>
						<input type="date" id="birthday_edit" name="birthday_edit"  onchange="setAge2()" required><label id="lb_birthday_edit" style="color:red; font-size:13px ; font-style: italic "></label>

						<label for="age" style="margin-left: 150px;">Tuổi:</label>
						<input type="number" id="age_edit" name="age_edit" readonly> 
						<br>
						<label for="hometown">Quê quán: <label id="lb_hometown_edit" style="color:red; font-size:13px ; font-style: italic "></label> </label>
						<input type="text" id="hometown_edit" name="hometown_edit" required>

						<label for="address">Địa chỉ: <label id="lb_address_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_edit" name="address_edit" required>

						<label for="education">Trình độ: <label id="lb_education_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_edit" name="education_edit" required>

						<label for="phone_number">Số điện thoại: <label id="lb_phone_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="tel" id="phone_number_edit" name="phone_number_edit" required>

						<label for="email">Email: <label id="lb_email_edit" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="email" id="email_edit" name="email_edit" required>


						<input type="submit" id='update' name="update" value="Cập nhật">

					</form>
					<button class="cancle-btn">Hủy bỏ</button>
				</div>
			</div>
		</div>






		<!-- Them giao vien -->
		<div class="modal-bg-add">
			<div class="modal-content-add">
				<div>
					<form id="form_add" name="form_add" method="post">

						<h1>Thêm Giáo viên</h1>

						<label for="teacher_name">Tên giáo viên: <label id="lb_name_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="teacher_name_add" name="teacher_name_add" required placeholder="Nhập tên giáo viên">

						<label for="gender">Giới tính:</label>
						<select id="gender_add" name="gender_add">
							<option>Nam</option>
							<option>Nữ</option>
						</select>

						<label for="birthday">Ngày sinh:</label>
						<input type="date" id="birthday_add" name="birthday_add" onchange="setAge()"><label id="lb_birthday_add" style="color:red; font-size:13px ; font-style: italic "></label>

						<label for="age" style="margin-left: 150px;">Tuổi:</label>
						<input type="number" id="age_add" name="age_add" readonly> 
						<br>
						<label for="hometown">Quê quán: <label id="lb_hometown_add" style="color:red; font-size:13px ; font-style: italic "></label> </label>
						<input type="text" id="hometown_add" name="hometown_add" required placeholder="Nhập quê quán">

						<label for="address">Địa chỉ: <label id="lb_address_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="address_add" name="address_add" required placeholder="Nhập địa chỉ">

						<label for="education">Trình độ: <label id="lb_education_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="text" id="education_add" name="education_add" required placeholder="Nhập trình độ">

						<label for="phone_number">Số điện thoại: <label id="lb_phone_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="tel" id="phone_number_add" name="phone_number_add" required placeholder="Nhập số diện thoại">

						<label for="email">Email: <label id="lb_email_add" style="color:red; font-size:13px ; font-style: italic "></label></label>
						<input type="email" id="email_add" name="email_add" required placeholder="Nhập email">


						<input type="submit" id='add' name="add" value="Thêm">

					</form>
					<button class="cancle-btn-add">Hủy bỏ</button>
				</div>
			</div>
		</div>
		<!-- <p style="margin-left: 80%; font-style:italic; font-size:13px"> <?php echo '*Tổng số giáo viên: ' . $i - 1 . '  Nam: ' . $nam . '  Nữ: ' . $nu ?> </p> -->

		<div class="add-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thêm giáo viên thành công!</h3>
		</div>
		<div class="update-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thay đổi thành công!</h3>
		</div>
		<div class="delete-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Xóa thành công!</h3>
		</div>

		<div id="modal-ques">
			<div class="delete-ques">
				<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
				<h4>Bạn chắc chắn muốn xóa?</h4>
				<div style="display:flex ;justify-content: space-evenly;align-items: center">

					<input type="submit" style="background-color:#52a95f; height: 44px;width: 80px" id="delete-cancle" value="Hủy bỏ"></input>
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete" value="Xóa"></input>

				</div>
			</div>


			<div class="delete-ques2" style="max-width: 333px;">
				<img src="../assets/images/Help-icon.png" alt="" style=" width: 40px;">
				<h4>Giáo viên đã có nhiều dữ liệu liên quan. Việc xóa sẽ ảnh hưởng đến cơ sở dữ liệu. <br> Bạn chắc chắn muốn xóa?</h4>
				<div style="display:flex ;justify-content: space-evenly;align-items: center">

					<input type="submit" style="background-color:#52a95f; height: 44px;width: 80px" id="delete-cancle2" value="Hủy bỏ"></input>
					<input type="submit" style="background-color: #d52828;  height: 44px;width: 80px" id="delete2" value="Xóa"></input>

				</div>
			</div>

		</div>

		

		<div class="change-pass-success">
			<img src="../assets/images/icon_success.png" alt="" style=" width: 40px;">
			<h3>Thay đổi mật khẩu thành công!</h3>
		</div>


	</main>




	<footer>
		<p>© 2023 Hệ thống quản lý giáo dục. All rights reserved.</p>
	</footer>

	<script>
		ds_lopHD = <?php print_r($jsonlistClassActive); ?>;
		ds_giaovien = <?php print_r($jsonListTeacher); ?>;
		ds_tk_gv = <?php print_r($jsonListtk_gv); ?>;
		ds_gv_lop = <?php print_r($jsonListClass); ?>;
	</script>;
	<script src="../../assets/js/manageTeacher.js"></script>





</html>