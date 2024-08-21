import { createClient } from '@supabase/supabase-js'

// Create a single supabase client for interacting with your database
const supabase = createClient('https://ividghsmcwfjxsgumkny.supabase.co/)', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Iml2aWRnaHNtY3dmanhzZ3Vta255Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjQxNzMwNTYsImV4cCI6MjAzOTc0OTA1Nn0.2EjsXqZGbDkdPJ5OCT5E7FhXThvLglsuji78DIG2t0w')