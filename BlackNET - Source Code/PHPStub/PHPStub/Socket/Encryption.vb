Imports System.Security.Cryptography
Namespace HTTPSocket
    Public Module Encryption
        Public Function RSA_Encrypt(ByVal Input As String, ByVal Key As String) As String
            Dim output As String
            Using RSA As New RSACryptoServiceProvider(2048)
                RSA.PersistKeyInCsp = False
                RSA.FromXmlString(Key)
                Dim buffer As Byte() = System.Text.Encoding.UTF8.GetBytes(Input)
                Dim encrypted As Byte() = RSA.Encrypt(buffer, True)
                output = Convert.ToBase64String(encrypted)
            End Using
            Return output
        End Function
        Public Function RSA_Decrypt(ByVal Input As String, ByVal Key As String) As String
            Dim plain As Byte()
            Using rsa As New RSACryptoServiceProvider(2048)
                rsa.PersistKeyInCsp = False
                rsa.FromXmlString(Key)
                Dim buffer As Byte() = Convert.FromBase64String(Input)
                plain = rsa.Decrypt(buffer, True)
            End Using
            Return System.Text.Encoding.UTF8.GetString(plain)
        End Function
    End Module
End Namespace