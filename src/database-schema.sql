CREATE TABLE [users] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [username] varchar(50) UNIQUE NOT NULL,
  [password] varchar(255) NOT NULL,
  [full_name] varchar(100),
  [email] varchar(100),
  [phone] varchar(20),
  [address] text,
  [role] varchar(20),
  [created_at] datetime
)
GO

CREATE TABLE [categories] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [name] varchar(100) UNIQUE NOT NULL,
  [description] text
)
GO

CREATE TABLE [products] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [name] varchar(100) NOT NULL,
  [description] text,
  [price] decimal(10,2) NOT NULL,
  [quantity] int NOT NULL,
  [image] varchar(255),
  [category_id] int,
  [created_at] datetime
)
GO

CREATE TABLE [orders] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [user_id] int,
  [order_date] datetime NOT NULL,
  [status] varchar(50),
  [total_price] decimal(10,2),
  [shipping_address] text
)
GO

CREATE TABLE [order_details] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [order_id] int,
  [product_id] int,
  [quantity] int NOT NULL,
  [price] decimal(10,2) NOT NULL
)
GO

CREATE TABLE [reviews] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [user_id] int,
  [product_id] int,
  [rating] int NOT NULL,
  [comment] text,
  [created_at] datetime
)
GO

ALTER TABLE [products] ADD FOREIGN KEY ([category_id]) REFERENCES [categories] ([id])
GO

ALTER TABLE [orders] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [order_details] ADD FOREIGN KEY ([order_id]) REFERENCES [orders] ([id])
GO

ALTER TABLE [order_details] ADD FOREIGN KEY ([product_id]) REFERENCES [products] ([id])
GO

ALTER TABLE [reviews] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [reviews] ADD FOREIGN KEY ([product_id]) REFERENCES [products] ([id])
GO
