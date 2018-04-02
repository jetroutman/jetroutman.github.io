//Jacob Troutman
//CSI 440
//April 2016
#include <iostream>
#include <fstream>
#include <string>
#include <windows.h>
#include <stdio.h>
#include <stdlib.h>
#include <climits>
#include <math.h>
#include <time.h>

using namespace std;

bool debug = false;
bool debug2 = false;
bool bdebug = false;

struct matrix {
	int nudenum;
	char direction;
};

struct map {
	bool path;
	bool node;
	int nodenum;
	bool mouse;
	bool fuzz;
	bool trap;
	bool cheese;
	bool gold;
	bool danger;
	bool smell;
	bool aroma;
	double danger_level;
	bool unknown;
	int visited;
	double conditions;
};

void road_conditions(map maze[62][43], int node, char direction) {
	//Down  -45, -44.9, -5
	//Level -10,     0, 10
	//Up      5,  44.9, 45
	//random number between 1-901 and subtract 451
	debug2 && cout << "begins creating road conditions\n";
	double condition;
	double down = 0, level = 0, up = 0;
	int angle = rand() % 901;
	angle -= 451;
	debug2 && cout << "begins creating road conditions part 2 with angle " << angle << "\n";
	if (angle < -50) {
		debug2 && cout << "begins creating road conditions down\n";
		if (angle <= -449) {
			down = 1;
		}
		else {
			down = ((double)angle - -449) / (-50 - -449);
		}
	}if (angle > -100 && angle < 100) {
		debug2 && cout << "begins creating road conditions level\n";
		if (angle < 0) {
			level = ((double)angle) / (-100);
		}
		else {
			level = ((double)angle) / (100);
		}
	}if (angle > 50) {
		debug2 && cout << "begins creating road conditions up\n";
		if (angle < 449) {
			up = (449 - (double)angle) / (449 - 50);
		}
		else {
			up = 1;
		}
	}
	bdebug && cout << "Angle: " << angle << " down: " << down << " level: " << level << " up: " << up << endl;
	//Clear  0, 20, 30
	//Rain  18, 40, 58
	//Ice   40, 60, 81
	//Snow  68, 88, 100
	double clear = 0, rain = 0, ice = 0, snow = 0;
	int weather = rand() % 100;
	if (weather < 30) {
		if (weather <= 20) {
			clear = ((double)weather) / (20);
		}
		else {
			clear = (30 - (double)weather) / (30 - 20);
		}
	}if (weather > 18 && weather < 58) {
		if (weather < 40) {
			rain = (40 - (double)weather) / (40 - 18);
		}
		else {
			rain = ((double)weather - 40) / (58 - 40);
		}
	}if (weather > 40 && weather < 81) {
		if (weather < 60) {
			ice = (60 - (double)weather) / (60 - 40);
		}
		else {
			ice = ((double)weather - 60) / (81 - 60);
		}
	}if (weather > 68) {
		if (weather < 88) {
			snow = (88 - (double)weather) / (88 - 68);
		}
		else {
			snow = ((double)weather - 88) / (100 - 88);
		}
	}
	bdebug && cout << "Weather: " << weather << " clear: " << clear << " rain: " << rain << " ice: " << ice << " snow: " << snow << endl;
	if (clear > .6) {
		condition = 0;
	}
	else if (rain<.9 && level>.5) {
		condition = 0;
	}
	else if (rain>.85 && up>.8) {
		condition = -1.5;
	}
	else if (rain>.85 && down>.9) {
		condition = -1.5;
	}
	else if (snow>.9 && level>.75) {
		condition = -1.5;
	}
	else if (snow>.9 && up>.85) {
		condition = -3;
	}
	else if (snow>.8 && down>.65) {
		condition = -6;
	}
	else if (ice>.8) {
		condition = -6;
	}
	else {
		condition = 0;
	}
	for (int i = 0; i < 62; i++) {
		for (int j = 0; j < 42; j++) {
			if (maze[i][j].nodenum == node) {
				int l = i;
				int m = j;
				if (direction == 'W') {
					l -= 1;
					while (maze[l][m].node == false) {
						maze[l][m].conditions = condition;
						l -= 1;
					}
				}
				else if (direction == 'D') {
					m += 1;
					while (maze[l][m].node == false) {
						maze[l][m].conditions = condition;
						m += 1;
					}
				}
				else if (direction == 'S') {
					l += 1;
					while (maze[l][m].node == false) {
						maze[l][m].conditions = condition;
						l += 1;
					}
				}
				else if (direction == 'A') {
					m -= 1;
					while (maze[l][m].node == false) {
						maze[l][m].conditions = condition;
						m -= 1;
					}
				}
			}
		}
	}
	bdebug && cout << "caused the condition " << condition << endl;
}

int createmap(map maze[62][43]) {
	//Input  :A 2dimensional array
	//Output :the amount of total nodes in the maze
	//Purpose:To create the maze from a txt file
	string inputfilename = "maze.txt";
	ifstream inputfile;
	inputfile.open(inputfilename.c_str());
	while (!inputfile.is_open()) {
		cout << "Can not find the maze.txt file would you like to try another file name:";
		getline(cin, inputfilename);
		inputfile.open(inputfilename.c_str());
	}
	char placement;
	int k = 0;
	for (int i = 0; i<62; i++) {
		for (int j = 0; j<42; j++) {
			inputfile >> placement;
			maze[i][j].conditions = 0;
			maze[i][j].visited = -1;
			maze[i][j].unknown = false;
			maze[i][j].cheese = false;
			maze[i][j].fuzz = false;
			maze[i][j].trap = false;
			maze[i][j].gold = false;
			maze[i][j].danger_level = 0;
			if (placement == 'W') {
				maze[i][j].path = false;
				maze[i][j].node = false;
				maze[i][j].mouse = false;
			}
			else if (placement == 'N') {
				maze[i][j].path = true;
				maze[i][j].node = true;
				maze[i][j].nodenum = k;
				k++;
				debug && cout << "at maze[" << i << "][" << j << "].nodenum you have node number: " << k << endl;
				maze[i][j].mouse = false;
			}
			else if (placement == 'P') {
				maze[i][j].path = true;
				maze[i][j].node = false;
				maze[i][j].mouse = false;
			}
		}
	}

	debug && cout << "The number of nodes you have is " << k << endl;

	inputfile.close();
	bool flag = false;
	while (flag == false) {
		for (int i = 0; i<62; i++) {
			for (int j = 0; j<42; j++) {
				if (flag == false && maze[i][j].node == true) {
					maze[i][j].mouse = true;
					flag = true;
				}
			}
		}
	}
	int cheese = rand() % 10;
	int trap = rand() % 10;
	debug && cout << cheese << " " << trap << endl;
	for (int i = 0; i<62; i++) {
		for (int j = 0; j<42; j++) {
			if (maze[i][j].path == true && maze[i][j].mouse == false) {//ensures that fuzz is in a path and not on the mouse when it starts
				int random = rand() % 10;
				debug && cout << random << "\n";
				if (random == cheese) {
					maze[i][j].cheese = true;
					maze[i][j].aroma = true;
					int random2 = rand() % 10;
					debug && cout << random << "\n";
					if (random2 == trap) {
						maze[i][j].trap = true;
						debug2 && cout << "trap placed at:" << i << j << endl;
					}
					else maze[i][j].trap = false;
				}
			}
		}
	}
	for (int i = 0; i<62; i++) {
		for (int j = 0; j<42; j++) {
			if (maze[i][j].trap == true) {
				maze[i][j].danger = true;
				maze[i + 1][j].danger = true;
				maze[i - 1][j].danger = true;
				maze[i][j + 1].danger = true;
				maze[i][j - 1].danger = true;
				debug2 && cout << "danger placed around:" << i << j << endl;
			}
		}
	}
	Sleep(5000);
	int fuzz = 1;
	while (fuzz >= 1) {
		int point1 = rand() % 62;
		int point2 = rand() % 43;
		debug && cout << point1 << "\t" << point2 << "\n";
		if (maze[point1][point2].path == true && maze[point1][point2].mouse == false) {//ensures that fuzz is in a path and not on the mouse when it starts
			maze[point1][point2].fuzz = true;
			maze[point1][point2].smell = true;
			maze[point1 + 1][point2].smell = true;
			maze[point1 - 1][point2].smell = true;
			maze[point1][point2 + 1].smell = true;
			maze[point1][point2 - 1].smell = true;
			fuzz--;
		}
	}
	for (int i = 0; i < 62; i++) {//Add road conditions
		for (int j = 0; j < 42; j++) {
			if (maze[i][j].nodenum == 23) {
				maze[i][j].gold = true;
			}
		}
	}


	for (int i = 0; i < 62; i++) {//Add road conditions
		for (int j = 0; j < 42; j++) {
			if (maze[i][j].node == true) {
				if (maze[i + 1][j].path == true) {
					road_conditions(maze, maze[i][j].nodenum, 'S');
				}
				if (maze[i - 1][j].path == true) {
					road_conditions(maze, maze[i][j].nodenum, 'W');
				}
				if (maze[i][j + 1].path == true) {
					road_conditions(maze, maze[i][j].nodenum, 'D');
				}
				if (maze[i][j - 1].path == true) {
					road_conditions(maze, maze[i][j].nodenum, 'A');
				}
			}
		}
	}

	return k;
}

void create_knowledge(map kb[62][43], map maze[62][43]) {
	//Input  :A 2dimensional array
	//Output :the amount of total nodes in the maze
	//Purpose:To create the knowledge base
	for (int i = 0; i<62; i++) {
		for (int j = 0; j<42; j++) {
			if (maze[i][j].mouse == true) {
				kb[i][j].mouse = true;
				kb[i][j].path = true;
				kb[i][j].unknown = false;
			}
			else {
				kb[i][j].cheese = false;
				kb[i][j].fuzz = false;
				kb[i][j].trap = false;
				kb[i][j].gold = false;
				kb[i][j].path = false;
				kb[i][j].mouse = false;
				kb[i][j].unknown = true;
			}
			kb[i][j].danger_level = 0;
			kb[i][j].visited = 0;
			kb[i][j].danger = false;
			kb[i][j].smell = false;
		}
	}
}

void showmap(map maze[62][43]) {
	//Input  :The 2D array that represents the maze
	//Output :
	//Purpose:To display the maze to the screen
	//cheese == 36 == $
	//trap == 35 == #
	//fuzz == 64 == @
	//gold == 33 == !
	//for kb agent unknown == 43 == +
	char place;
	bool flag = false;
	for (int i = 0; i<62; i++) {
		for (int j = 0; j<42; j++) {
			if (maze[i][j].unknown == true) {
				place = 43;
				if (maze[i][j].danger_level>0) {
					place = (maze[i][j].danger_level * 26) + 63;
				}
				cout << place;
			}
			else if (maze[i][j].mouse == true) {
				place = 21;
				cout << place;
				if (maze[i][j].danger == true || maze[i][j].smell == true)
					flag = true;
			}
			else if (maze[i][j].path == true) {
				place = 32;
				if (maze[i][j].cheese == true) {
					place = 36;
					if (maze[i][j].trap == true) {
						place = 35;
					}
				}
				if (maze[i][j].fuzz == true)
					place = 64;
				if (maze[i][j].gold == true)
					place = 33;
				if (maze[i][j].visited>0)
					cout << maze[i][j].visited;
				else cout << place;
			}
			else if (maze[i][j].path == false) {
				place = 178;
				cout << place;
			}
			else {
				debug && cout << "maze wrong? ";
				debug && cout << maze[i][j].path;
			}
		}
		cout << endl;
	}
	if (flag == true) {
		debug2 && cout << "There's a sense of smell or danger!!!!!\n";
	}
}

int findmouse(map maze[62][43]) {
	//Input  :The 2D array that represents the maze
	//Output :the location of the mouse returned in an single int format
	//Purpose:To locate the mouse in the maze
	bool flag = false;
	int k;
	while (flag == false) {
		for (int i = 0; i<62; i++) {
			for (int j = 0; j<42; j++) {
				if (flag == false && maze[i][j].mouse == true) {
					flag = true;
					k = i * 100;
					k += j;
				}
			}
		}
	}
	return k;
}

bool goaltest(map maze[62][43], int &score) {
	int mouse = findmouse(maze);
	int i, j;
	bool finish = false;
	j = mouse % 100;
	i = mouse / 100;
	if (maze[i][j].trap) {
		debug && cout << "here's a trap " << maze[i][j].trap << endl;
		score = -10000;
		finish = true;
	}
	else if (maze[i][j].fuzz) {
		cout << "here's fuzz " << maze[i][j].fuzz << endl;
		score = -10000;
		finish = true;
	}
	if (maze[i][j].gold) {
		cout << "here's gold " << maze[i][j].gold << endl;
		score = 10000;
		finish = true;
	}
	if (maze[i][j].conditions == 6) {
		int death = rand() % 2;
		int luck = rand() % 2;
		if (death = luck) {
			cout << "Death due to road conditions\n";
			finish = true;
		}
	}
	return finish;
}

void update_kb(map maze[62][43], map kb[62][43]) {
	//Input  :the map of the maze
	//Output :An updated knowledge base
	//Purpose:To update the knowledge base agent on its status quo
	int mouse = findmouse(kb);
	int j = mouse % 100;
	int i = mouse / 100;
	//aroma smeel dange gold
	if (maze[i][j].smell == true) {
		int count = 0;
		if (kb[i + 1][j].unknown == true) {
			count++;
		}if (kb[i - 1][j].unknown == true) {
			count++;
		}if (kb[i][j + 1].unknown == true) {
			count++;
		}if (kb[i][j - 1].unknown == true) {
			count++;
		}if (kb[i + 1][j].unknown == true) {
			kb[i + 1][j].danger_level += (double)count / 26;
			debug2 && cout << "danger down: " << kb[i + 1][j].danger_level << endl;
		}if (kb[i - 1][j].unknown == true) {
			kb[i - 1][j].danger_level += (double)count / 26;
			debug2 && cout << "danger up: " << kb[i - 1][j].danger_level << endl;
		}if (kb[i][j + 1].unknown == true) {
			kb[i][j + 1].danger_level += (double)count / 26;
			debug2 && cout << "danger right: " << kb[j + 1][j].danger_level << endl;
		}if (kb[i][j - 1].unknown == true) {
			kb[i][j - 1].danger_level += (double)count / 26;
			debug2 && cout << "danger left: " << kb[j - 1][j].danger_level << endl;
		}
		debug2 && cout << "UPDATED DANGER LEVEL\n";
	}
	if (maze[i][j].danger == true) {
		int count = 0;
		if (kb[i + 1][j].unknown == true) {
			count++;
		}if (kb[i - 1][j].unknown == true) {
			count++;
		}if (kb[i][j + 1].unknown == true) {
			count++;
		}if (kb[i][j - 1].unknown == true) {
			count++;
		}if (kb[i + 1][j].unknown == true) {
			kb[i + 1][j].danger_level += (double)count / 26;
			debug2 && cout << "danger down: " << kb[i + 1][j].danger_level << endl;
		}if (kb[i - 1][j].unknown == true) {
			kb[i - 1][j].danger_level += (double)count / 26;
			debug2 && cout << "danger up: " << kb[i - 1][j].danger_level << endl;
		}if (kb[i][j + 1].unknown == true) {
			kb[i][j + 1].danger_level += (double)count / 26;
			debug2 && cout << "danger right: " << kb[i][j + 1].danger_level << endl;
		}if (kb[i][j - 1].unknown == true) {
			kb[i][j - 1].danger_level += (double)count / 26;
			debug2 && cout << "danger left: " << kb[i][j - 1].danger_level << endl;
		}
		debug2 && cout << "UPDATED DANGER LEVEL\n";
	}
	if (maze[i][j].danger == false && maze[i][j].smell == false) {
		kb[i][j].danger_level = 0;
		kb[i - 1][j].danger_level = 0;
		kb[i + 1][j].danger_level = 0;
		kb[i][j - 1].danger_level = 0;
		kb[i][j + 1].danger_level = 0;
	}
}

char attempt(map kb[62][43], char current) {
	//Input  :The KB and the current direction
	//Output :the next logical move according to the knowledge base
	//Purpose:To actually use the knowledge base to make moves
	int dang = 1;
	int mouse = findmouse(kb);
	int j = mouse % 100;
	int i = mouse / 100;
	int l = i, m = j;
	if (current == 'W') {
		l -= 1;
	}if (current == 'D') {
		m += 1;
	}if (current == 'S') {
		l += 1;
	}if (current == 'A') {
		m -= 1;
	}
	char oring = current;//saves current
	if (kb[i + 1][j].danger_level != 0) {
		current = 'S';
		dang = kb[i + 1][j].danger_level;
	}if (dang == 0 || dang > kb[i - 1][j].danger_level) {
		current = 'W';
		dang = kb[i + 1][j].danger_level;
	}if (dang == 0 || dang > kb[i][j - 1].danger_level) {
		current = 'A';
		dang = kb[i + 1][j].danger_level;
	}if (dang == 0 || dang > kb[i][j + 1].danger_level) {
		current = 'D';
		dang = kb[i + 1][j].danger_level;
	}if (kb[l][m].danger_level <= dang) {
		current = oring;
	}
	return current;
}

void turn(char &current) {
	if (current == 'W')
		current = 'D';
	else if (current == 'D')
		current = 'S';
	else if (current == 'S')
		current = 'A';
	else if (current == 'A')
		current = 'W';
}

int make_move(map maze[62][43], map kb[62][43], char &current) {
	//Input  :The 2D array that represents the maze and the current action of the mouse
	//Output :
	//Purpose:To represent a simple reflex agent
	static int maxv = 2;
	static int stick = 1;
	static bool dart = true;
	int i, j, k, l, m, n, score = 0;
	bool bump = false, flag = false;
	bdebug && cout << "enters function to make a move\n";
	k = findmouse(maze);
	j = k % 100;
	i = k / 100;
	l = i;
	m = j;
	if (maze[i][j].aroma == true) {//pick up cheese
		flag = true;
		maze[i][j].cheese = false;
		maze[i][j].aroma = false;
		score += 1;
		bdebug && cout << "there's an aroma\n";
	}

	if (current == 'W')
		l = i - 1;
	else if (current == 'S')
		l = i + 1;
	else if (current == 'A')
		m = j - 1;
	else if (current == 'D')
		m = j + 1;
	debug2 && cout << "before the checks begin\n";

	if (maze[i][j].node == true) {
		if (maze[l][m].conditions > 0) {
			score += maze[l][m].conditions;
			if (maze[i - 1][j].path == true && maze[i - 1][j].conditions < maze[l][m].conditions) {
				current = 'W';
				l = i - 1;
				m = j;
			}
			if (maze[i + 1][j].path == true && maze[i - 1][j].conditions < maze[l][m].conditions) {
				current = 'S';
				l = i + 1;
				m = j;
			}
			if (maze[i][j - 1].path == true && maze[i - 1][j].conditions < maze[l][m].conditions) {
				current = 'A';
				l = i;
				m = j - 1;
			}
			if (maze[i][j + 1].path == true && maze[i - 1][j].conditions < maze[l][m].conditions) {
				current = 'D';
				l = i;
				m = j + 1;
			}
		}
		else if (kb[i][j].visited > maxv) {
			maxv += 3;
			turn(current);
		}
	}

	if (maze[i][j].danger == true) { //senses danger of trap
		bdebug && cout << "there's an sense of danger\n";
		update_kb(maze, kb);
		if (kb[i][j].visited < maxv) {//turns because only a few visits
			if (kb[l][m].unknown) {
				bdebug && cout << "runs from danger\n";
				turn(current);
				score += -1;
			}
			else {
				bdebug && cout << "safe to move forward\n";
				maze[i][j].mouse = false;
				maze[l][m].mouse = true;
				kb[i][j].mouse = false;
				kb[i][j].visited += 1;
				kb[l][m].mouse = true;
				kb[l][m].unknown = false;
				kb[l][m].path = true;
				score += -1;
			}
		}
		else {//to many loops
			current = attempt(kb, current);//returns new current for an attempt to be made
			if (current == 'W')
				l = i - 1;
			else if (current == 'S')
				l = i + 1;
			else if (current == 'A')
				m = j - 1;
			else if (current == 'D')
				m = j + 1;
			if (stick == 1) {
				bdebug && cout << "throws stick\n";
				if (maze[l][m].trap == true) {
					maze[l][m].trap = false;
					maze[l][m].danger = false;
					maze[l + 1][m].danger = false;
					maze[l - 1][m].danger = false;
					maze[l][m + 1].danger = false;
					maze[l][m - 1].danger = false;
					update_kb(maze, kb);
				}
				stick = 0;
				score += -1;
			}
			else {
				bdebug && cout << "has to be brave\n";
				if (maze[l][m].path == false) {//bump into wall check
					bdebug && cout << "there's an wall\n";
					bump = true;
					kb[l][m].path = false;
					kb[l][m].unknown = false;
					kb[l][m].danger_level = 0;
				}
				if (bump == true) {//bump into wall
					bdebug && cout << "turns from wall\n";
					turn(current);
					score += -1;
					flag = true;
				}
				else {
					bdebug && cout << "no wall\n";
					maze[i][j].mouse = false;
					maze[l][m].mouse = true;
					kb[i][j].mouse = false;
					kb[i][j].visited += 1;
					kb[l][m].mouse = true;
					kb[l][m].unknown = false;
					kb[l][m].path = true;
					score += -1;
				}
			}
		}
	}
	else {
		bdebug && cout << "there's no sense of danger\n";
		debug2 && cout << maze[l][m].path << endl;
		if (flag == false && maze[l][m].path == false) {//bump into wall check
			bdebug && cout << "there's an wall\n";
			bump = true;
			kb[l][m].path = false;
			kb[l][m].unknown = false;
		}
		if (bump == true) {//bump into wall
			bdebug && cout << "turns from the wall\n";
			turn(current);
			score += -1;
			flag = true;
		}
		else {
			maze[i][j].mouse = false;
			maze[l][m].mouse = true;
			kb[i][j].mouse = false;
			kb[i][j].visited += 1;
			kb[l][m].mouse = true;
			kb[l][m].unknown = false;
			kb[l][m].path = true;
			score += -1;
		}
	}
	debug2 && cout << "reached end of move\n";
	return score;
}

int main() {
	int numnodes = 10, score = 0;
	char current = 'W';
	bool goal = false;
	map maze[62][43];
	srand(time(NULL));
	numnodes = createmap(maze);
	map kb[62][43];
	char choice = 'n';
	while (choice != 'q') {
		cout << "Please enter w for the Wumpus world game\tor q to quit\n";
		cout << "Before you start you should know that if you see a letter in the knowledge bass(second printed maze)\n";
		cout << "that means there is danger the further into the alphabet the more dangerous it believes the location to be\n";
		cout << "Also the debug statements showing you the weather conditions and percieved percepts can be turned off on line 18\n";
		cin >> choice;
		while (choice != 'w' && choice != 'q') {
			cout << "That's in invalid input please try again: ";
			cin >> choice;
		}
		if (choice == 'w') {
			create_knowledge(kb, maze);
			showmap(maze);
			while (goal == false) {
				score += make_move(maze, kb, current);
				showmap(maze);
				cout << endl;
				showmap(kb);
				cout << endl;
				goal = goaltest(maze, score);
				//Sleep(500);
				if (goal == true) {
					int k = findmouse(maze);
					int j = k % 100;
					int i = k / 100;
					if (score<10000 && maze[i][j].gold == false) {
						cout << "That's unfortunate you lost";
					}
					else cout << "Congrats probably won't happen again for a while good luck";
				}
				//else system("CLS");
			}
		}
	}
	return 0;
}