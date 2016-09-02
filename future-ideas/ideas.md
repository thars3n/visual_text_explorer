##Current Ideas
###Additional color modulation
* This would be implemented as an option
* Currently all of the colors are based on HSV values where Saturation and Value are locked at 1, which essentially means we are stuck at 360 colors
* To remedy this we can increment the Saturation or Hue values as we assign colors to the terms in the list file
* For example, if we have 400 terms in the list file the first 200 terms can have Hue values between 0 and 360 and have Saturation and Value locked at 1, and then the next 200 terms can have Hue values between 0 and 360 and Value at 1 but then have Saturation locked at .75. This would then double our number of possible colors from 360 to 720
* This could be incredibly useful for list files that are over 360 terms long
