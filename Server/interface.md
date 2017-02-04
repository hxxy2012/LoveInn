# 爱心驿站APP接口

>   说明: 下列所有接口的访问前缀为
>
>   http://qcloud.waydrow.com/LoveInn/index.php/Home/App/

## 1. 登录

##### 1.1 interface

`login`

##### 1.2 method

Post

##### 1.3 send

-   username
-   password

##### 1.4 return

-   user_id: 登录成功
-   0: 失败

## 2. 注册

##### 2.1 interface

`register`

##### 2.2 method

get/post

##### 2.3 send

-   username
-   password

##### 2.4 return

-   0: 用户名重复
-   user_id: 成功

## 3.获取活动列表

##### 3.1 interface

`getActivityList`

##### 3.2 method

get

##### 3.3 return

example:

```json
[
  {
    "id": "1",
    "name": "活动1",
    "summary": "summary1"
  },
  {
    "id": "2",
    "name": "活动2",
    "summary": "summary2"
  }
]
```

## 4. 按id获取活动详情

##### 4.1 interface

`getActivityInfoById`

##### 4.2 method

get/post

##### 4.3 send

-   id

##### 4.4 return

example

```json
{
  "id": "1",
  "name": "活动1",
  "summary": "summary1",
  "info": "哈哈哈",
  "begintime": null,
  "endtime": null,
  "location": null,
  "categoryid": null,
  "contact": null,
  "agencyid": null,
  "capacity": null,
  "isend": "0"
}
```

