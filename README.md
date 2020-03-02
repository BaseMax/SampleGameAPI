# Matno Contest - Back-End Programming

# Sample Game API

A tiny implement such as google play game web service using PHP.

## Features

- API
- Create app, game
- Create user (email, random password just for one time)
- Submit score

## Game API

### createApp

http://localhost/matno4/?method=createApp
```json
{
	status: "failed",
	message: "Cannot create an app without passing package name!"
}
```

http://localhost/matno4/?method=createApp&packageName=org.max.blog

Without headers:

```json
{
	status: "failed",
	message: "This token and key is not valid!"
}
```

http://localhost/matno4/?method=createApp&packageName=org.max.blog

With headers:


```json
{
	status: "success",
	message: "successfully created!",
	result: {
		publicKey: "ksqmpzlduf80i5s9ljhce2g9n9yurxl0kfw6avrdgftm4zzqyn",
		token: "qn2vwnad16rjfcxb6vu9u3neb153ca7wotbacphyl6dklj5it8"
	}
}
```

again refresh:

```json
{
	status: "failed",
	message: "Cannot create an app with dublicate package name!"
}
```


## createUser

http://localhost/matno4/SampleGameAPI/src/?method=registerUser

```json
{
	status: "failed",
	message: "Cannot create a user without passing device, version and packageName!"
}
```

http://localhost/matno4/SampleGameAPI/src/?method=registerUser&packageName=org.max.blog&version=1.0.0&device=samsung-SL10&email=maxmaxmax456@asrez.com

```json
{
	status: "success",
	message: "successfully created!",
	result: {
		publicKey: "n1owugbezggmgdubwzbwni9jhq7t2xqqjj5heywrbwt4k1a1jo",
		token: "6rrnr9dmvb1cwfjva6yhoot3ydc8tkvcbwtj96m5pia2tzbgz7"
	}
}
```

Again reload:

```
{
	status: "failed",
	message: "Cannot create a user with dublicate email address!"
}
```

### loginUser

http://localhost/matno4/SampleGameAPI/src/?method=loginUser&packageName=org.max.blog&version=1.0.0&device=samsung-SL10&email=max@asrez.comxxxxxxx

```json
{
	status: "failed",
	message: "Email not exists!"
}
```

http://localhost/matno4/SampleGameAPI/src/?method=loginUser&packageName=org.max.blog&version=1.0.0&device=samsung-SL10&email=max@asrez.com

```json
{
	status: "success",
	message: "successfully created!",
	result: {
		email: "max@asrez.com"
	}
}
```

### authUser

http://localhost/matno4/SampleGameAPI/src/?method=authUser&packageName=org.max.blog&version=1.0.0&device=samsung-SL10&email=max@asrez.com&code=4561

```json
{
	status: "success",
	message: "Wellcome!",
	result: {
		session: "vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v"
	}
}
```

and reload:

```json
{
	status: "failed",
	message: "You not have this premission to do this task!"
}
```

### submitScore

http://localhost/matno4/SampleGameAPI/src/?method=submitScore&packageName=org.max.blog&value=500

```json
{
	status: "failed",
	message: "Cannot verify you without passing device, version, packageName, email, session and value!"
}
```


http://localhost/matno4/SampleGameAPI/src/?method=submitScore&packageName=org.max.blog&version=1.0.0&device=samsung-SL10&email=max@asrez.com&session=vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v&value=500

```json
{
	status: "success",
	message: "Great, Enjoy!"
}
```


### highScore

http://localhost/matno4/SampleGameAPI/src/?method=highScore&packageName=org.max.blog

```json
{
	status: "success",
	message: "You get list as below...",
	result: {
		list: [
			{
				id: "5",
				appID: "2",
				userID: "1",
				session: "vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v",
				value: "1648",
				datetime: "2020-03-01 03:08:55"
			},
			{
				id: "4",
				appID: "2",
				userID: "1",
				session: "vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v",
				value: "840",
				datetime: "2020-03-01 03:08:53"
			},
			{
				id: "3",
				appID: "2",
				userID: "1",
				session: "vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v",
				value: "500",
				datetime: "2020-03-01 03:08:43"
			}
		],
		count: 0,
		hightest: null,
		lowest: null
	}
}
```

But it's not secure, so i did change PHP code and results to:

```json
{
	status: "success",
	message: "You get list as below...",
	result: {
		list: [
			{
				value: "1648"
			},
			{
				value: "840"
			},
			{
				value: "500"
			}
		],
		count: 0,
		hightest: null,
		lowest: null
	}
}
```

---------

# Max Base

My nickname is Max, Programming language developer, Full-stack programmer. I love computer scientists, researchers, and compilers. ([Max Base](https://maxbase.org/))

## Asrez Team

A team includes some programmer, developer, designer, researcher(s) especially Max Base.

[Asrez Team](https://www.asrez.com/)
