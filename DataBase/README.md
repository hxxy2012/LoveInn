## [](注册审核(-1/0/1))爱心驿站数据库文档

### 迭代记录

| 版本   | 时间         | 说明   | 修改者     |
| ---- | ---------- | ---- | ------- |
| v1.0 | 2016.02.02 | 建表   | waydrow |
|      |            |      |         |
|      |            |      |         |

### volunteer (志愿者表)

| 字段       | 类型      | 说明               | 默认值     |
| -------- | ------- | ---------------- | ------- |
| id       | int     | 标识               |         |
| username | varchar | 用户名(默认为学号)       |         |
| password | varchar | 密码(md5)          |         |
| avatar   | varchar | 个人头像             |         |
| realname | varchar | 真实姓名             |         |
| age      | int     | 年龄               |         |
| sex      | varchar | 性别(m/f)          |         |
| idcard   | varchar | 身份证              |         |
| phone    | varchar | 电话               |         |
| email    | varchar | 电子邮箱             |         |
| info     | varchar | 个人简介             |         |
| stucard  | varchar | 学生证照片(审核使用)      |         |
| money    | int     | 爱心币(活动评分/2取整 累加) | 0       |
| ispass   | int     | 注册审核(-1/0/1)     | 0 (待审核) |

### activity (公益活动表)

| 字段         | 类型      | 说明        | 默认值    |
| ---------- | ------- | --------- | ------ |
| id         | int     | 标识        |        |
| name       | varchar | 活动名称      |        |
| summary    | varchar | 简介        |        |
| info       | varchar | 详细介绍      |        |
| begintime  | date    | 活动开始时间    |        |
| endtime    | date    | 活动结束时间    |        |
| location   | varchar | 活动地址      |        |
| categoryid | int     | 活动种类(外键)  |        |
| contact    | varchar | 联系电话      |        |
| agencyid   | int     | 公益机构(外键)  |        |
| capacity   | int     | 最大报名人数    |        |
| isend      | int     | 活动结束(0/1) | 0(未结束) |

### category (活动种类表)

| 字段   | 类型      | 说明   | 默认值  |
| ---- | ------- | ---- | ---- |
| id   | int     | 标识   |      |
| name | varchar | 种类名  |      |

### agency (公益机构表)

| 字段            | 类型      | 说明           | 默认值     |
| ------------- | ------- | :----------- | ------- |
| id            | int     | 标识           |         |
| username      | varchar | 用户名          |         |
| password      | varchar | 密码           |         |
| name          | varchar | 机构名          |         |
| photo         | varchar | 机构图片         |         |
| address       | varchar | 地址           |         |
| contact       | varchar | 联系方式         |         |
| certification | varchar | 审核材料(营业执照等)  |         |
| ispass        | int     | 注册审核(-1/0/1) | 0 (待审核) |

### apply (报名表)

| 字段         | 类型   | 说明                | 默认值  |
| ---------- | ---- | ----------------- | ---- |
| id         | int  | 标识                |      |
| userid     | int  | 志愿者id(外键)         |      |
| activityid | int  | 活动id(外键)          |      |
| time       | date | 报名时间              |      |
| rate       | int  | 组织者对志愿者的评分(10分满分) |      |