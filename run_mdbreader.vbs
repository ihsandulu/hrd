Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /k C:\Users\IT-PROGRAMMER\source\repos\MDBReader\bin\Debug\MDBReader.exe " & WScript.Arguments(0), 1, False
