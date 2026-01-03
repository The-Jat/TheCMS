<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ config('Site.title') }}</title>
	</head>
	<body>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #f1f1f1; padding: 40px 0; ">
			<tr>
				<td>
					<table width="100%" style="max-width: 680px;" cellpadding="0" cellspacing="0" border="0" align="center">
						<tr>
							<td><h2 style="text-align: center;margin-top: 0;font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;">{{ config('Site.title') }}</h2></td>
						</tr>
						<tr>
							<td  style="padding: 30px;background-color: #fff;font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;">
								{!! $description !!}
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>