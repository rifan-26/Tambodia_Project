# Implementation Plan - Social Media Links Support

- [x] 1. Add database column for video platform


  - Create migration to add `video_platform` column to `media` table
  - Column should be nullable string, values: 'youtube', 'tiktok', 'instagram', 'facebook', 'twitter'
  - Run migration to update database schema
  - _Requirements: 4.2_



- [ ] 2. Update Media model
  - Add `video_platform` to fillable array
  - Add `isExternalVideo()` method to check if video is from external link
  - Add `isUploadedVideo()` method to check if video is uploaded file



  - Add `getEmbedUrl()` method to generate platform-specific embed URLs
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5_

- [ ] 3. Enhance input form with platform detection
  - Add platform badge display element in input.blade.php
  - Add hidden field for video_platform


  - Update placeholder text to mention all supported platforms
  - Add JavaScript function to detect platform from URL using regex patterns
  - Add real-time platform detection on input change
  - Show platform badge with icon when platform is detected
  - _Requirements: 1.1, 1.2, 1.3, 2.1, 2.2, 2.3, 2.4, 2.5, 3.1, 3.2, 3.3_



- [ ] 4. Update backend validation and storage
  - Update MediaController validation rules to accept video_platform
  - Validate video_platform is one of supported platforms
  - Save video_platform field when storing media with external link
  - Ensure backward compatibility with existing video uploads
  - _Requirements: 1.4, 1.5, 4.2, 4.3_



- [ ] 5. Implement platform-specific embed rendering
  - Update landingpage.blade.php to check video_platform field
  - Add YouTube embed code (iframe)
  - Add TikTok embed code (blockquote + script)
  - Add Instagram embed code (blockquote + script)
  - Add Facebook embed code (iframe)
  - Add Twitter embed code (blockquote + script)
  - Add fallback for uploaded video files (existing behavior)
  - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5_

- [ ] 6. Add error handling and user feedback
  - Show error message for invalid URLs
  - Show warning for unsupported platforms
  - Add form validation before submission
  - Handle embed loading failures on landing page
  - _Requirements: 1.4, 3.4, 3.5_

- [ ]* 7. Test with real URLs from each platform
  - Test YouTube URL detection and embed
  - Test TikTok URL detection and embed
  - Test Instagram URL detection and embed
  - Test Facebook URL detection and embed
  - Test Twitter URL detection and embed
  - Test invalid URL handling
  - Test unsupported platform handling
  - _Requirements: All_

- [ ]* 8. Add CSS styling for platform badges and embeds
  - Style platform badge with icons and colors
  - Style embed containers for consistent sizing
  - Add responsive design for mobile devices
  - Add loading states for embeds
  - _Requirements: 3.1, 3.2_
