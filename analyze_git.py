import subprocess
import collections

def analyze_git_log():
    try:
        # Get the full git log with author name and changed files
        # --name-only: show changed files
        # --format="%aN": show author name
        # The output format will be:
        # Author Name
        # file1.txt
        # file2.js
        #
        # Author Name
        # ...
        
        cmd = ["git", "log", "--pretty=format:AUTHOR:%aN", "--name-only"]
        result = subprocess.run(cmd, capture_output=True, text=True, encoding='utf-8', errors='replace')
        
        if result.returncode != 0:
            print(f"Error running git log: {result.stderr}")
            return

        lines = result.stdout.splitlines()
        
        author_files = collections.defaultdict(set)
        current_author = None
        
        for line in lines:
            line = line.strip()
            if not line:
                continue
                
            if line.startswith("AUTHOR:"):
                current_author = line[len("AUTHOR:"):]
            else:
                if current_author:
                    author_files[current_author].add(line)
                    
        print("# Contributor Statistics")
        print(f"Total Contributors: {len(author_files)}")
        print("-" * 30)
        
        # Sort by number of files touched (descending)
        sorted_authors = sorted(author_files.items(), key=lambda item: len(item[1]), reverse=True)
        
        for author, files in sorted_authors:
            print(f"User: {author}")
            print(f"Unique Files Modified: {len(files)}")
            print("-" * 30)

    except Exception as e:
        print(f"An error occurred: {e}")

if __name__ == "__main__":
    analyze_git_log()
