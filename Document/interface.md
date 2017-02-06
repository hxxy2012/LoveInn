# 爱心驿站APP接口

>   说明: 
>
>   1.  下列所有接口的访问前缀为 http://qcloud.waydrow.com/LoveInn/index.php/Home/App/
>
>   2.  数据库图片存放格式为 `/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg`
>
>       访问图片需加前缀 http://qcloud.waydrow.com
>
>       注意: 前缀最后没有 `/`

### 迭代记录

| 版本   | 时间         | 说明             | 修改者     |
| ---- | ---------- | -------------- | ------- |
| v1.0 | 2017.02.02 | 初始化            | waydrow |
| v1.1 | 2017.02.07 | 活动信息中添加photo字段 | waydrow |

## 1. 登录

### 1.1 interface

`login`

### 1.2 method

Post

### 1.3 send

-   username
-   password

### 1.4 return

-   user_id: 登录成功
-   0: 失败

## 2. 注册

### 2.1 interface

`register`

### 2.2 method

get/post

### 2.3 send

-   username
-   password

### 2.4 return

-   0: 用户名重复
-   user_id: 成功

## 3.获取活动列表

### 3.1 interface

`getActivityList`

### 3.2 method

get

### 3.3 return

example:

```json
[
  {
    "id": "6",
    "name": "这是活动1",
    "summary": "没有活动简介",
    "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0249cb29.jpg"
  },
  {
    "id": "7",
    "name": "这是活动2",
    "summary": "这是简介2",
    "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0840c81a.jpg"
  }
]
```

## 4. 按id获取活动详情

### 4.1 interface

`getActivityInfoById`

### 4.2 method

get/post

### 4.3 send

-   id

### 4.4 return

example

```json
{
  "id": "6",
  "name": "这是活动1",
  "summary": "没有活动简介",
  "info": "这是info",
  "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0249cb29.jpg",
  "begintime": "2017-02-07",
  "endtime": "2017-02-08",
  "location": "中国海洋大学",
  "categoryid": "1",
  "contact": "124124",
  "agencyid": "4",
  "capacity": "12",
  "isend": "0"
}
```

## 5. 获取志愿者头像

### 5.1 interface

`getAvatar`

### 5.2 method

get/post

### 5.3 send

-   user_id

### 5.4 return

图片地址

形如: `/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg`

## 6. 获取学生证头像

### 6.1 interface

`getStucard`

其余同5.获取志愿者头像

## 7. 获取志愿者个人信息

### 7.1 interface

`getVolunteerInfo`

### 7.2 method

get/post

### 7.3 send

-   user_id

### 7.4 return

example

```json
{
  "id": "1",
  "username": "222",
  "password": "bcbe3365e6ac95ea2c0343a2395834dd",
  "avatar": "/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg",
  "realname": "你好",
  "age": null,
  "sex": null,
  "idcard": null,
  "phone": null,
  "email": null,
  "info": null,
  "stucard": null,
  "money": "0",
  "ispass": "0"
}
```

## 8. 上传志愿者头像

### 8.1 interface

`uploadAvatar`

### 8.2 method

post

### 8.3 send

发送文件

`key` 为 `avatar`

### 8.4 return

-   0: 失败
-   1: 成功

## 9. 修改志愿者个人信息(实名认证)

### 9.1 interface

`changeVolunteerInfo`

### 9.2 method

post

### 9.3 send

-   id, realname, sex, age, idcard, phone, email, info
-   学生证字段`stucard`上传文件, `key` 为 `stucard`

### 9.4 return

-   0: 失败
-   1: 成功

