@echo off
setlocal enabledelayedexpansion

:: Check if directory is passed as an argument
if "%~1"=="" (
    echo Usage: %~nx0 <directory>
    exit /b 1
)

:: Set the target directory
set "targetDir=%~1"

:: Loop through all .html files in the directory and subdirectories
for /r "%targetDir%" %%F in (*.html) do (
    set "file=%%F"
    set "newFile=%%~dpnF.blade.php"
    ren "!file!" "!newFile!"
    echo Renamed: %%F to !newFile!
)

echo All .html files have been renamed to .blade.php.
pause
