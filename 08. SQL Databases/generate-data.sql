START TRANSACTION;

Declare @Id int
Set @Id = 1

While @Id <= 2
Begin
   INSERT INTO `users` values (
          'name - ' + CAST(@Id as nvarchar(10)),
          'real-name - ' + CAST(@Id as nvarchar(10)),
          'password - ' + CAST(@Id as nvarchar(10)),
          'birthname - ' + DATEADD(day, (ABS(CHECKSUM(NEWID())) % 16250), '1940-1-1 00:00:00.001')
   Set @Id = @Id + 1
End

COMMIT;
