<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
	<title>demo导航</title>
</head>
<link rel="stylesheet" type="text/css" href="./demo/style.css">
<body>
	<div class="nav">
		<table border="0">
			<tr>
				<td colspan="2" class="title">人脸</td>
			</tr>
			<tr>
				<th>接口解释</th>
				<th width="80px">链接</th>
			</tr>
			<tr>
				<td>人脸检测</td>
				<td><a href="./demo/face_detection.php">demo</a></td>
			</tr>
			<tr>
				<td>人脸标点</td>
				<td><a href="./demo/face_landmark.php">demo</a></td>
			</tr>
			<tr>
				<td>人脸对比</td>
				<td><a href="./demo/face_comparison.php">demo</a></td>
			</tr>
			<tr>
				<td colspan="2" ><b>person 操作接口</b></td>
			</tr>
			<tr>
				<td>获取person列表</td>
				<td><a href="./demo/face_persons.php">demo</a></td>
			</tr>
			<tr>
				<td>新建person</td>
				<td><a href="./demo/face_person_create.php">demo</a></td>
			</tr>
			<tr>
				<td>在某person下添加face_id</td>
				<td><a href="./demo/face_faces_add.php">demo</a></td>
			</tr>
			<tr>
				<td>上传图片，验证person</td>
				<td><a href="./demo/face_verification.php">demo</a></td>
			</tr>
			<tr>
				<td>删除person</td>
				<td><a href="./demo/face_person_delete.php">demo</a></td>
			</tr>
			<tr>
				<td>删除某person下face_id</td>
				<td><a href="./demo/face_face_delete.php">demo</a></td>
			</tr>
			<tr>
				<td colspan="2"><b>group 操作接口</b></td>
			</tr>
			<tr>
				<td>获取groups列表</td>
				<td><a href="./demo/face_groups.php">demo</a></td>
			</tr>
			<tr>
				<td>新建group</td>
				<td><a href="./demo/face_group_create.php">demo</a></td>
			</tr>
			<tr>
				<td>在某group下添加person_id</td>
				<td><a href="./demo/face_person_add.php">demo</a></td>
			</tr>
			<tr>
				<td>上传图片，验证某gruop下与上传图片最相似的person</td>
				<td><a href="./demo/face_search.php">demo</a></td>
			</tr>
			<tr>
				<td>删除group</td>
				<td><a href="./demo/face_group_delete.php">demo</a></td>
			</tr>
			<tr>
				<td>删除某gruop下person</td>
				<td><a href="./demo/face_group_person_delete.php">demo</a></td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="title" colspan="2">在线滤镜</td>
			</tr>
			<tr>
				<th>接口解释</th>
				<th width="80px">链接</th>
			</tr>
			<tr>
				<td>获取滤镜资源列表</td>
				<td><a href="./demo/filter_style.php">demo</a></td>
			</tr>
			<tr>
				<td>艺术滤镜</td>
				<td><a href="./demo/filter_art.php">demo</a></td>
			</tr>
			<tr>
				<td>照片滤镜</td>
				<td><a href="./demo/filter_ordinary.php">demo</a></td>
			</tr>
		</table>
	</div>
	
</body>
</html>