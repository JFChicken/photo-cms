import os
from importlib import util


check = util.find_spec("PIL")
if check is None:
    print ('PIL is NOT installed attempting to install')
    os.system('python3 -m pip install Pillow')
    

check = util.find_spec("resizeimage")
if check is None:
    print ('resizeimage is NOT installed ')
    os.system('python3 -m pip install python-resize-image')
    
myCmd = os.popen('which exiftool').read()
print(myCmd)
if myCmd == '':
    print('missing exiftool')
    os.system('curl -O https://www.sno.phy.queensu.ca/~phil/exiftool/Image-ExifTool-11.61.tar.gz')
    os.system('gzip -dc Image-ExifTool-11.61.tar.gz | tar -xf -')
    os.system('rm Image-ExifTool-11.61.tar.gz')
    exiftoolDir = '{}/Image-ExifTool-11.61'.format(os.getcwd())
    os.chdir( exiftoolDir )
    os.system('perl Makefile.PL')
    os.system('make test')
    os.system('sudo make install')
    os.system('rm -rf exiftoolDir')
    