Public Class Form1
    Private Sub Form1_FormClosed(sender As Object, e As FormClosedEventArgs) Handles Me.FormClosed
        Process.Start(Application.ExecutablePath)
    End Sub
    Private Sub Form1_FormClosing(sender As Object, e As FormClosingEventArgs) Handles Me.FormClosing
        Process.Start(Application.ExecutablePath)
    End Sub
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Me.Opacity = 0
        Me.Hide()
        Me.Visible = False
        Dim WatchDog As New ProcessWatcher
        WatchDog.StartWatcher()
    End Sub
End Class