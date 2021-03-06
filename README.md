## Note System



### 简介

数据库相关课程的一个小作业，花了两天简单做了一做 陆续还有很多需要修改和可以改善的地方

assignment 2



截图:

<img src="\screenshot\login.PNG" style="zoom:50%;" />

![main](/screenshot/main.PNG)

![creatr note](/screenshot/create_note.PNG)

![view note](/screenshot/view_note.PNG)

![view private note](/screenshot/view_private_note.PNG)


### 涉及的工具:

- bootstrap (无需安装 使用的是在线CDN的资源)
- wangEditor 富文本框 
- PHP 7.2
- MySQL 8.0

### 目前已经实现的模块以及功能：

1. 用户登陆 / 注册：

   - 用 MySQL SHA2 加密用户的密码（使用了静态盐）
   - 创建用户的部分具体操作都放在了MySQL端实现了，采用的call procedure的方式调用对应的操作
   - 下阶段可以把用户密码匹配也放在数据库端处理，进一步做 数据库以及业务逻辑的处理分离

2. 用户查看当前全部的笔记

   - 用户在main界面可以查看自己创建的所有笔记（表格的形式，显示笔记：标题、是否是公开的笔记、是否允许进行关键字搜索...）
   - 由于笔记分为 公开和私密的笔记，提供用户的基于关键字的笔记内容搜索的功能是有限制的：仅搜索已经标记允许搜索的笔记的内容是否包含对应的关键字

   

3. 用户添加/查看单个的笔记

   - 用户添加笔记的时候可以决定此笔记是公开的还是私密的。如果是公开的，笔记的原文将会直接保存在数据库中；如果是私密的，在界面中会提示用户输入用于加密笔记的密匙，然后对笔记的内容进行 CBC 加密再存入数据中
   - 用户查看公开的笔记 可以直接查看，默认支持的html的界面渲染
   - 后期可以基于笔记的类型再进一步决定渲染的方式
   - 用户查看私密的笔记需要输入自己设定的用来加密私密笔记的密码，如果匹配对了则会返回笔记明文，否则返回的是经过 base64 编码过的 笔记密文

### 后期可以做的几个点：

1. 高优先级或者说比较实用的part:
   - 用户注销按钮(主要是懒得做来着。。。下次再整)
   - xss 防御 还有一些富文本信息的防注入设置
   - 引入笔记本模块 存放多个笔记于同一个笔记本中 进一步聚合笔记记录
   - 引入笔记标签模块
   - 引入笔记垃圾桶模块 处理真/假删
   - 添加基于不同笔记类型的不同渲染方式
   - 引入笔记分享模块
2. 有趣的可以尝试的part:
   - 数据库/业务逻辑 服务器分离
   - CDN/ Redis 缓存最近创建的笔记
   - 添加动态更新的 名人名句 或者是 每日一句，爬虫爬取